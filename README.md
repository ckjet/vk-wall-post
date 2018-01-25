# vk-wall-post
A Symfony project created on January 24, 2018, 8:13 am.

### Installation
For working project you need specify vk access token.

You can get it by url: http://oauth.vk.com/oauth/authorize?redirect_uri=http://oauth.vk.com/blank.html&response_type=token&client_id=`{app_id}`&scope=offline,wall,photos

### Preparing
For getting all posts you need to run cli-command: `php bin/console import:start --all [page]`

You can set [page] from which import starts

### Working
You need add to cron this command: `php bin/console import:start`