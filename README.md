## Summary
This is a simple e-commerce project integrated with midtrans payment gateway (https://midtrans.com/)

## Database 

### Master Data

```sql
CREATE TABLE [category](
	[id] [varchar](36) NOT NULL,
    [category_code] [varchar](36) NOT NULL,
	[category_name] [varchar](36) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [brand](
	[id] [varchar](36) NOT NULL,
    [brand_code] [varchar](36) NOT NULL,
	[brand_name] [varchar](36) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

```sql
CREATE TABLE [product](
	[id] [varchar](36) NOT NULL,
    [brand_id] [varchar](36)NOT NULL,
	[category_id] [varchar](36)NOT NULL,
    [product_code] [varchar](36) NOT NULL,
	[product_name] [varchar](36)NOT NULL,
    [stock] [integer](11) NOT NULL,
    [price] [decimal](22) NOT NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

## User Authentication

Custom user authentication with role based system and permission using (https://spatie.be/docs/laravel-permission/v6/basic-usage/role-permissions)
