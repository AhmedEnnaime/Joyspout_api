<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Joyspout Api

These are the api used in Joyspout application, they're created with laravel with a sanctum authentication.

## API Reference

#### User Login

```http
  POST http://localhost:8000/api/login
```

| Parameter  | Type     | Description                |
| :--------- | :------- | :------------------------- |
| `email`    | `string` | **Required**. Your API key |
| `password` | `string` | **Required**. Your API key |

#### User Register

```http
  POST http://localhost:8000/api/register
```

| Parameter    | Type     | Description                |
| :----------- | :------- | :------------------------- |
| `name`       | `string` | **Required**. Your API key |
| `birthday`   | `date`   | **Required**. Your API key |
| `phone`      | `string` | **Required**. Your API key |
| `email`      | `string` | **Required**. Your API key |
| `password`   | `string` | **Required**. Your API key |
| `c_password` | `string` | **Required**. Your API key |
| `img`        | `string` | **Required**. Your API key |

#### Add category

```http
  POST http://localhost:8000/api/categories
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`    | `string` | **Required**. Your API key |

#### Get all categories

```http
  GET http://localhost:8000/api/categories
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name`    | `string` | **Required**. Your API key |

#### Share post

```http
  POST http://localhost:8000/api/posts
```

| Parameter     | Type       | Description                |
| :------------ | :--------- | :------------------------- |
| `description` | `string`   | **Required**. Your API key |
| `content`     | `string[]` | **Required**. Your API key |
| `category_id` | `int[]`    | **Required**. Your API key |

#### Update post

```http
  PUT http://localhost:8000/api/posts/{id}
```

| Parameter | Type  | Description                |
| :-------- | :---- | :------------------------- |
| `id`      | `int` | **Required**. Your API key |

#### Delete post

```http
  POST http://localhost:8000/api/posts/{id}
```

| Parameter | Type  | Description                |
| :-------- | :---- | :------------------------- |
| `id`      | `int` | **Required**. Your API key |

#### Add comment

```http
  POST http://localhost:8000/api/comment/{id}
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Required**. Your API key |
| `content` | `string` | **Required**. Your API key |

#### Delete comment

```http
  POST http://localhost:8000/api/comment/{id}
```

| Parameter | Type  | Description                |
| :-------- | :---- | :------------------------- |
| `id`      | `int` | **Required**. Your API key |

#### Update comment

```http
  POST http://localhost:8000/api/comment/{id}
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `id`      | `int`    | **Required**. Your API key |
| `content` | `string` | **Required**. Your API key |

#### Like post

```http
  POST http://localhost:8000/api/like/{id}
```

| Parameter | Type  | Description                                   |
| :-------- | :---- | :-------------------------------------------- |
| `id`      | `int` | **Required**. id of the post you want to like |

#### Remove like

```http
  POST http://localhost:8000/api/like/{id}
```

| Parameter | Type  | Description                  |
| :-------- | :---- | :--------------------------- |
| `id`      | `int` | **Required**. id of the like |

## Tech Stack

**Client:** VueJs, Typescript, TailwindCss

**Server:** Laravel

**Authentication:** Sanctum

## Feedback

If you have any feedback, please reach out to me at ahmedennaime20@gmail.com or on Linkedin Ahmed Ennaime.

## Support

For support, email ahmedennaime20@gmail.com or reach me in Linkedin Ahmed Ennaime.
