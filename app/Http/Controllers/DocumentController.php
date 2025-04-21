<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
  

    public function import(Request $request)
    {
        $request->validate([
            'document' => 'required|file|max:10240|mimes:pdf,doc,docx,txt,md',
        ]);

        $file = $request->file('document');
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        
        // Store the file
        $path = $file->store('imports', 'public');
        $fullPath = Storage::disk('public')->path($path);
        
        // Extract content based on file type
        $content = '';
        
        if (in_array($extension, ['txt', 'md'])) {
            // For text files
            $content = Storage::disk('public')->get($path);
        } elseif (in_array($extension, ['doc', 'docx'])) {
            // For Word documents using phpoffice/phpword
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($fullPath);
            $sections = $phpWord->getSections();
            $text = [];
            
            foreach ($sections as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text[] = $element->getText();
                    } elseif (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $childElement) {
                            if (method_exists($childElement, 'getText')) {
                                $text[] = $childElement->getText();
                            }
                        }
                    }
                }
            }
            
            $content = implode("\n", $text);
        } elseif ($extension === 'pdf') {
            // For PDF files using smalot/pdfparser
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($fullPath);
            $content = $pdf->getText();
        }

        // Create a new page with the file content
        $page = Auth::user()->pages()->create([
            'title' => $fileName,
            'content' => $content,
            'icon' => $this->getIconForFileType($extension),
        ]);

        // Return to the newly created page
        return redirect()->route('pages.show', $page)->with('success', "File '{$originalName}' successfully imported!");
    }

    private function getIconForFileType($extension)
    {
        return match($extension) {
            'pdf' => '📄',
            'doc', 'docx' => '📝',
            'txt' => '📃',
            'md' => '📋',
            default => '📑',
        };
    }
}