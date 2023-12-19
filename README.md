## Summary
This is a simple e-commerce project integrated with midtrans payment gateway (https://midtrans.com/). The features available in this project are login, register, email verification and password reset using Google SMTP, admin dashboard to manage users and master data, features for users include displaying product lists, shopping carts, checkout, and payment gateway

## Database 

### Master Data

```sql
CREATE TABLE [category](
	[id] [varchar](36) NOT NULL,
    [category_code] [nvarchar](255) NOT NULL,
	[category_name] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [brand](
	[id] [varchar](36) NOT NULL,
    [brand_code] [nvarchar](255) NOT NULL,
	[brand_name] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [product](
	[id] [varchar](36) NOT NULL,
    [brand_id] [varchar](36)NOT NULL,
	[category_id] [varchar](36)NOT NULL,
    [product_code] [nvarchar](255) NOT NULL,
	[product_name] [nvarchar](255)NOT NULL,
    [stock] [integer](11) NOT NULL,
    [price] [decimal](22) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [product_asset](
	[id] [varchar](36) NOT NULL,
    [product_id] [varchar](36)NOT NULL,
    [file_name] [nvarchar](255) NOT NULL,
	[file_url] [nvarchar](255) NOT NULL,
	[is_primary] [bool] NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

## User Authentication

Custom user authentication with role based system and permission using (https://spatie.be/docs/laravel-permission/v6/basic-usage/role-permissions)

```sql
CREATE TABLE [modul](
	[id] [varchar](36) NOT NULL,
    [name] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [permissions](
	[id] [varchar](36) NOT NULL,
    [modul_id] [varchar](36)NOT NULL,
    [name] [nvarchar](255) NOT NULL,
	[guard_name] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [roles](
	[id] [varchar](36) NOT NULL,
    [name] [nvarchar](255) NOT NULL,
    [guard_name] [nvarchar](255) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [role_has_permissions](
	[permission_id] [varchar](36) NOT NULL,
    [role_id] [varchar](36)NOT NULL,
)
```

```sql
CREATE TABLE [password_resets](
	[email] [nvarchar](256) NOT NULL,
    [token] [nvarchar](256) NOT NULL,
    [created_at] [datetime] NOT NULL,
)
```

```sql
CREATE TABLE [users](
	[id] [varchar](36) NOT NULL,
    [role_id] [varchar](36)NOT NULL,
    [name] [nvarchar](255) NOT NULL,
    [email] [nvarchar](256) NOT NULL,
	[password] [nvarchar](256) NOT NULL,
    [email_verified_at] [datetime] NULL,
    [remember_token] [nvarchar](256) NOT NULL,
    [is_email_verfied] [bool] NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [user_profile](
	[id] [varchar](36) NOT NULL,
    [user_id] [varchar](36)NOT NULL,
    [full_name] [nvarchar](255)  NULL,
    [phone_number] [nvarchar](256)  NULL,
	[address] [nvarchar](256)  NULL,
    [profile_asset] [nvarchar](256) NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```
## Transaction

```sql
CREATE TABLE [carts](
	[id] [varchar](36) NOT NULL,
    [user_id] [varchar](36)NOT NULL,
    [qty] [integer](11) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [transactions](
	[id] [varchar](36) NOT NULL,
    [user_id] [varchar](36)NOT NULL,
    [transaction_time] [datetime] NOT NULL,
    [transaction_code] [nvarchar](256)  NULL,
    [transaction_status] [enum('cancel','pending','paid')]  NULL ,
    [total_price] [decimal](22) NOT NULL,
    [total_tax] [decimal](22) NOT NULL,
    [price_after_tax] [decimal](22) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [checkouts](
	[id] [varchar](36) NOT NULL,
    [product_id] [varchar](36)NOT NULL,
    [transaction_id] [varchar](36)NOT NULL,
    [qty] [integer](11) NOT NULL,
    [price] [decimal](22) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

## Gmail SMTP setting env

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Install and run the application on a local development environment

```
composer install
```
OR
```
composer update
```
Create new .env and copy paste from .env.example

```
php artisan key:generate
```

Setting up Database 
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

```
php artisan serve
```

## Running PHP Unit Test
Documentation (https://laravel.com/docs/10.x/testing)

```
php artisan test
```
