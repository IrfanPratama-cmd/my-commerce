### Database 

## Master Data

```sql
CREATE TABLE [category](
	[id] [varchar](36) NOT NULL,
    [category_code] [varchar](36) NULL,
	[category_name] [varchar](36) NULL,
	[created_at] [datetime] NOT NULL,
	[updated_at] [datetime] NULL,
)
```

## User Authentication

Custom user authentication with role based system and permission using (https://spatie.be/docs/laravel-permission/v6/basic-usage/role-permissions)
