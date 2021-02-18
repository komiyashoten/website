小宮商店wordpress開発環境

===

Wordpress 5.5.x
PHP 7.4.x
MySQL 5.7.x

# git管理除外ファイル
.htaccess
wp-config.php

wp-content/*（wp-content/の以下のフォルダ以外）
!wp-content/mu-plugins/
!wp-content/plugins/
!wp-content/themes/

wp-content/plugins/hello.php
ai1wm-backups/（バックアップファイルは除外）
*.log
*.sql
*.sqlite


# セットアップ
ローカルでWPの環境をセット
Macの場合：Local by Fly Wheel推奨
Windowsの場合：Xampなど
Dockerなどの設置は想定していないので、各自Wordpressをローカルで動く状態の上、公開フォルダをGit管理

