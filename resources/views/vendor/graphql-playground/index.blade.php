<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, minimal-ui">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Source+Code+Pro:400,700" rel="stylesheet">
    <title>Taskord GraphQL Playground</title>
    <link
        rel="stylesheet"
        href="{{ \MLL\GraphQLPlayground\DownloadAssetsCommand::cssPath() }}"
    />
    <link
        rel="shortcut icon"
        href="{{ \MLL\GraphQLPlayground\DownloadAssetsCommand::faviconPath() }}"
    />
    <script src="{{ \MLL\GraphQLPlayground\DownloadAssetsCommand::jsPath() }}"></script>
</head>
<body>
    <div id="root" />
    <script type="text/javascript">
        window.addEventListener('load', function () {
            const root = document.getElementById('root');

            GraphQLPlayground.init(root, {
                endpoint: "{{url(config('graphql-playground.endpoint'))}}",
                subscriptionEndpoint: "{{config('graphql-playground.subscriptionEndpoint')}}",
            })
        })
    </script>
</body>
</html>
