Description:
=====
Board is demo application that allow user publish advertisement.<br />
App components:
<ul>
<li>Registration</li>
<li>Authorization</li>
<li>Email confirmation</li>
<li>RBAC (role base access control)</li>
<li>CRUD operations</li>
</ul>
Modules:<br />
<ul>
<li>Public section</li>
<li>API (comming)</li>
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


Api specification:
=====
<b>User:</b>

<ol>
    <li>
        <u>Auth user</u>
        <ul>
            <li>url: /api/login</li>
            <li>request type: post</li>
            <li>params:
                <ul>
                    <li>login (string) required</li>
                    <li>password (string) required</li>
                </ul>
            </li>
            <li>response: security token
        </ul>
    </li>


    <li>
        <u>View user</u>
        <ul>
            <li>url: /api/user/view</li>
            <li>request type: get</li>
            <li>params:
                <ul>
                    <li>id (integer) required</li>
                </ul>
            </li>
            <li>response: operation status</li>
        </ul>
    </li>
    
    <li>
        <u>Update user</u>
        <ul>
            <li>url: /api/user/update?token=xxxxxxxxxxxxxxxxxxxxx</li>
            <li>request type: post</li>
            <li>params:
                <ul>
                    <li>name (string)</li>
                    <li>email (string)</li>
                    <li>password (string)</li>
                    <li>password_repeat (string)</li>
                </ul>
            </li>
            <li>response: operation status</li>
        </ul>
    </li>
</ol>

<b>Product:</b>

<ol>
    <li>
        <u>List of products</u>
        <ul>
            <li>url: /api/product</li>
            <li>request type: get</li>
            <li>response: attributes of product list</li>
        </ul>
    </li>


    <li>
        <u>View product</u>
        <ul>
            <li>url: /api/product/view/id</li>
            <li>request type: get</li>
            <li>params:
                <ul>
                    <li>id (integer) required</li>
                </ul>
            </li>
            <li>response: attributes of product</li>
        </ul>
    </li>
    
    <li>
        <u>Create product</u>
        <ul>
            <li>url: /api/product/create?token=xxxxxxxxxxxxxxxxxxxxx</li>
            <li>request type: post</li>
            <li>params:
                <ul>
                    <li>title (string) required</li>
                    <li>price (float) required</li>
                    <li>image (file) required</li>
                </ul>
            </li>
            <li>response: operation status</li>
        </ul>
    </li>
    
    <li>
        <u>Update product</u>
        <ul>
            <li>url: /api/product/update/id?token=xxxxxxxxxxxxxxxxxxxxx</li>
            <li>request type: post</li>
            <li>params:
                <ul>
                    <li>title (string) required</li>
                    <li>price (float) required</li>
                    <li>image (file) required</li>
                </ul>
            </li>
            <li>response: operation status</li>
        </ul>
    </li>
    
    <li>
        <u>Delete product</u>
        <ul>
            <li>url: /api/product/delete/id?token=xxxxxxxxxxxxxxxxxxxxx</li>
            <li>request type: get</li>
            <li>params:
                <ul>
                    <li>id (integer) required</li>
                </ul>
            </li>
            <li>response: operation status</li>
        </ul>
    </li>
</ol>