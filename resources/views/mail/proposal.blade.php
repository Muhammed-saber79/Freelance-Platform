<!DOCTYPE>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Notification Message</title>
    </head>
    <body>
        <h2 style="color: cyan">Hello, {{ $notifiable->name }}</h2>
        <p>A new proposal has been added to your project "{{ $proposal->project->title }}" by {{ $freelancer->name }}.</p>
        <p><a href="{{ route('projects.show', $proposal->project_id) }}">Go To Project</a></p>
        <p>Thank You.</p>
    </body>
</html>
