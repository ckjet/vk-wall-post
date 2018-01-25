# vk-wall-post
A Symfony project created on January 24, 2018, 8:13 am.

This application allows you to organize a news site based on the publications of the vk group. It uses vk api for getting publications from group.

### Installation
For working project you need specify vk access token.

You can get it by url: http://oauth.vk.com/oauth/authorize?redirect_uri=http://oauth.vk.com/blank.html&response_type=token&client_id={app_id}&scope=offline,wall,photos

Where {app_id} - Application id on https://vk.com/developers

### Preparing
For getting all posts you need to run cli-command: `php bin/console import:posts --all [page]`

You can set [page] from which import starts

### Working
You need add to cron this command: `php bin/console import:posts`