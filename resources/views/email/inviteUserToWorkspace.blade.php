<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace Invitation</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-height: 60px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ThinkDeck Workspace Invitation</h1>
    </div>
    
    <div class="content">
        <p>Hello,</p>
        
        <p>You've been invited to join the <strong>"{{ $workspace->name }}"</strong> workspace on ThinkDeck.</p>
        
        <p>{{ $workspace->owner->name }} has invited you to collaborate in this workspace. Join now to start working together!</p>
        
        @if($workspace->description)
        <p><strong>Workspace description:</strong> {{ $workspace->description }}</p>
        @endif
        
        <div style="text-align: center;">
            <a href="{{ route('workspaces.join.invite', ['workspace_ref' => urlencode($workspace->workspace_ref)]) }}" class="button">Accept Invitation</a>
        </div>
        
        <p>If the button above doesn't work, copy and paste this link into your browser:</p>
        <p style="word-break: break-all;">{{ url('/workspaces/join/invite?workspace_ref='.urlencode($workspace->workspace_ref)) }}</p>
        
    </div>
    
    <div class="footer">
        <p>If you received this invitation by mistake, please ignore this email or contact support.</p>
        <p>&copy; {{ date('Y') }} ThinkDeck. All rights reserved.</p>
    </div>
</body>
</html>