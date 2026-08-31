# Forumly

Forumly is a lightweight community discussion forum built with Laravel.

The project is inspired by Reddit's core discussion model while deliberately keeping the scope small and focused. Users can browse communities, create posts, attach files, comment, vote on posts, search discussions, and manage their own content.

The application demonstrates Laravel MVC, Eloquent relationships, authentication, authorization, middleware, file handling, AJAX interactions, automated testing, and responsive Blade UI.

## Features

### Authentication

* User registration
* Login and logout
* Profile management
* Password reset and email verification support

### Communities

* Browse available communities
* View posts belonging to a community
* Create posts directly inside a community
* Admin-only community management
* Create, edit, and delete communities

### Posts

Users can:

* Create posts
* View posts
* Edit their own posts
* Delete their own posts
* Select which community a post belongs to

Post ownership is enforced server-side using Laravel policies.

### Multi-file attachments

Posts support optional general-purpose file attachments.

Users can:

* Upload multiple files when creating a post
* Add additional files while editing a post
* Remove existing attachments
* Download attachments from posts

Each uploaded file stores metadata including:

* Original filename
* Storage path
* MIME type
* File size

Individual files are currently limited to **10 MB**.

### Comments

Authenticated users can leave comments on posts.

Comments are intentionally kept flat rather than using nested Reddit-style comment threads.

### Voting

Forumly uses a simple upvote system.

A user can:

* Upvote a post
* Click again to remove their vote

The relationship between users and voted posts is implemented as a many-to-many relationship through the `votes` table.

### Asynchronous voting

Voting uses JavaScript `fetch()` to update the vote without reloading the page.

The flow is:

```text
User clicks vote
      ↓
JavaScript fetch()
      ↓
Laravel vote endpoint
      ↓
Vote stored/removed
      ↓
JSON response
      ↓
Vote count updated in the page
```

### Search

The post feed supports searching by:

* Any field
* Post title
* Post body
* Title and body
* Author

Search results are paginated and Laravel preserves the current query parameters while navigating between pages.

### Roles and authorization

Forumly currently supports two roles:

```text
user
admin
```

Normal users can:

* Create posts
* Edit/delete their own posts
* Comment
* Vote

Administrators can additionally manage communities.

Admin functionality is protected by Laravel middleware.

## Technology

Forumly is built with:

* PHP
* Laravel
* Blade
* Eloquent ORM
* SQLite
* Tailwind CSS
* Alpine.js
* Vanilla JavaScript `fetch()`
* Vite
* PHPUnit
* GitHub Actions

Heroicons are used throughout the interface.

## Database structure

Forumly uses five main application tables:

```text
users
communities
posts
comments
votes
```

The main relationships are:

```text
User
 ├── has many Posts
 ├── has many Comments
 └── belongs to many Posts through Votes

Community
 └── has many Posts

Post
 ├── belongs to User
 ├── belongs to Community
 ├── has many Comments
 └── belongs to many Users through Votes

Comment
 ├── belongs to User
 └── belongs to Post

Vote
 ├── belongs to User
 └── belongs to Post
```

Post attachment metadata is stored in the post's `file_paths` JSON field rather than requiring a separate attachment table.

## Project structure

Important application files are organised using conventional Laravel structure:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── CommentController.php
│   │   ├── CommunityController.php
│   │   ├── PostController.php
│   │   └── VoteController.php
│   │
│   └── Middleware/
│       └── AdminMiddleware.php
│
├── Models/
│   ├── Comment.php
│   ├── Community.php
│   ├── Post.php
│   ├── User.php
│   └── Vote.php
│
└── Policies/
    └── PostPolicy.php

resources/
├── js/
│   └── app.js
│
└── views/
    ├── communities/
    ├── components/
    ├── layouts/
    └── posts/

tests/
└── Feature/
    ├── AdminTest.php
    ├── AttachmentTest.php
    ├── PostTest.php
    └── VoteTest.php
```

## Installation

Clone the repository:

```bash
git clone https://github.com/silentlie/Forumly.git
cd Forumly
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Create the SQLite database if it does not already exist:

```bash
touch database/database.sqlite
```

On Windows PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File
```

Run the migrations and seed demo data:

```bash
php artisan migrate --seed
```

Start the development environment:

```bash
composer dev
```

Alternatively, Laravel and Vite can be run separately:

```bash
php artisan serve
```

and:

```bash
npm run dev
```

## Testing

Run the automated test suite with:

```bash
composer test
```

The feature tests cover important behaviour including:

* Authenticated post creation
* Post validation
* Post ownership authorization
* Scoped post searching
* Vote toggling
* Guest vote protection
* Admin authorization
* Admin community management
* Multiple attachment uploads
* Attachment removal

## Continuous integration

GitHub Actions automatically:

1. Checks out the repository
2. Configures PHP
3. Installs Composer dependencies
4. Creates the Laravel environment
5. Installs frontend dependencies
6. Builds the frontend
7. Runs the automated test suite

This helps ensure committed changes continue to build and pass the application's tests.

## Security and authorization

Forumly does not rely only on hiding controls in the interface.

Laravel policies protect post modification on the server:

```text
Post owner
    ├── can edit
    └── can delete

Other users
    ├── cannot edit
    └── cannot delete
```

Admin functionality is separately protected using authentication and admin middleware.

Uploaded files are stored through Laravel's filesystem rather than being exposed directly through user-controlled paths.

## Scope

Forumly intentionally focuses on a small, complete forum rather than attempting to reproduce every Reddit feature.

The project does not currently include:

* Tags
* Nested comment threads
* Downvotes
* Karma
* Private messaging
* Notifications
* Recommendation algorithms
* WebSockets
* Realtime chat
* Complex moderation systems

This keeps the application focused while still demonstrating the main concepts of a modern Laravel web application.

## License

Forumly was created as a university web application development project.

Laravel and its dependencies remain subject to their respective licences.
