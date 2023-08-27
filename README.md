# personal-task-manager

This is a solution to the Personal Task Manager Challenge.

## Table of contents

- [Overview](#overview)
  - [The challenge](#the-challenge)
  - [Live Links](#live-links)
- [My process](#my-process)
  - [Built with](#built-with)
  - [Local development](#local-development)
  - [RestApi](#restapi)

## Overview

### The challenge

Users should be able to:

- Register and Login
- Add, Update, Read and Delete Tasks
- Tasks are cateorized into three categories: Personal, Work and Others
- Filter tasks by status and category
- Logout

### Live Links

- Backend URL: [Add solution URL here](https://your-solution-url.com)
- Frontend URL: [Add live site URL here](https://your-live-site-url.com)

### Built with

- Semantic HTML5 markup
- Flexbox
- CSS Grid
- Mobile-first workflow
- [Vite](https://vitejs.dev/) - js
- [Vue](https://vuejs.org/) - js Framework
- [Vue Apollo](https://apollo.vuejs.org/) - Vue Graphql Package
- [Laravel](https://laravel.com/) - PHP Framework
- [Lighthouse](https://lighthouse-php.com/) - Graphql Package
- [Tailwind](https://tailwindcss.com/) - For styles


### Local development

Frontend url: http://localhost:8080

Backend url: http://localhost:8000/graphiql - for GraphQL Playground

Api url: http://localhost:8000/graphql

---
<strong>Clone Project:</strong>
```
git clone https://github.com/Ruthiejayjay/personal-task-manager.git
```
---
<strong>Starting server:</strong>

Open new terminal in project and run the following
```
cd backend

cp .env.example .env

composer install

php artisan migrate

php artisan serve
```
---
<strong>Starting Clientside:</strong>

Open new terminal in project and run the following
```
cd frontend

npm install

npm run dev
```

### RestApi
Api url: http://localhost:8000/api

Check routes/api.php file for different routes