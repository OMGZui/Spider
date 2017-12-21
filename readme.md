# 爬虫

前言：爬取好玩的东西

## Usage

### 目录结构

```php

- 目录
    - app 爬虫包
    - databases 数据库
    - models 数据库映射模型
    - sqls 数据库sql
    - tools 工具
    
- 文件
    - index.php 入口
    - .env 配置文件
    - composer.json 依赖文件

```

### 使用

```php

git clone https://github.com/OMGZui/Spider.git
composer install
mv .env.example .env
cd app/douban/top250
php -f orm_top250.php
或
php orm_top250.php

```

## 依赖库

- [jaeger/querylist][1] 爬虫库
- [symfony/var-dumper][2] 调试
- [illuminate/database][3] 数据库ORM
- [vlucas/phpdotenv][4] .env配置

## 小目标

- [x] 豆瓣top250爬取
- [ ] 豆瓣战狼影评爬取
- [ ] ...

[1]: https://github.com/jae-jae/QueryList
[2]: https://github.com/symfony/var-dumper
[3]: https://github.com/illuminate/database
[4]: https://github.com/vlucas/phpdotenv
