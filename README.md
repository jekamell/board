board
=====
Description:
=====
Board is demo application that allow user publish advertisement.<br />
App components:
<ul>
<li>Registration</li>
<li>Authorization</li>
<li>Email confirmation</li>
<li>RBAC (role base access control)</li>
</ul>
Modules:<br />
<ul>
<li>Public section</li>
<li>API</li>
</ul>

Technology stack:
=====
<ul>
<li>php 5.4</li>
<li>mySql</li>
<li>twitter bootstrap</li>
</ul>

Requirements:
=====
<ul>
<li>php 5.4+</li>
<li>mysql</li>
</ul>

Installation:
=====
<ol>
<li>Clone repo (cd /www && git clone https://github.com/jekamell/board.git)</li>
<li>Log to MySql and create database: CREATE DATABASE `board` CHARACTER SET utf8 COLLATE utf8_general_ci;</li>
<li>Create user and grant access: GRANT ALL PRIVILEGES ON board.* To 'board'@'localhost' IDENTIFIED BY 'board';</li>
<li>Create local.php file with your environment settings (see /protected/config/local.php.example) and put there your credentials</li>
<li>Create /protected/runtime, /assets, /images/product directories and give full access for your http server user</li>
<li>Apply database migrations: ./protected/yiic migrate</li>
</ol>
 