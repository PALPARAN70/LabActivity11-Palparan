# LabActivity11-Palparan

Barangay Bulletin – Purok Palparan, Lab Activity 11 (Full-Stack Web
Development, 4-334). Builds on Lab 10: posts now show their author and tags,
signed-in residents can comment, and Kagawads can write posts from the site.
Laravel 13 (composer installed the latest), SQLite, Blade, Tailwind.

## Logins

Both use the password **bulletin2026** (stored hashed with `Hash::make`).

| Account | Email | Can do |
|---|---|---|
| Lola Palparan | lola.palparan@bulletin.test | comment (resident, gets 403 if she tries to post) |
| Kagawad Luis Palparan | kagawad.palparan@bulletin.test | comment and write new posts |

The 8 other residents come from `UserFactory` with the factory password.

## My 5 tags

Purok Palparan, Urgent, Libre, Schedule, and **Bakuna** (my own). I picked
Bakuna because vaccination schedules are one of the most common things the
barangay posts, and it ties back to my Lab 9 Bakuna Tracker.

## Lab 10 personalization kept

- 8 posts per page (Palparan has 8 letters)
- Custom category: Lost & Found
- Pinned post "Purok Palparan Clean-up Drive", published 2026-03-12 (my
  birthday), now tagged Purok Palparan + Urgent with `sync()` and at least 3
  comments, one from Lola

## Relationships and why

| Link | Type | Why |
|---|---|---|
| User → Author | hasOne | A login account owns at most one official profile. `authors.user_id` is unique and nullable, because residents have no profile and the 4 factory authors have no login |
| Author → Post | hasMany | One official writes many posts. `posts.author_id` points back |
| Post → Author | belongsTo | The post table holds the `author_id` key, so Post is the "belongs to" side |
| Post → Comment | hasMany | One post has many comments |
| Comment → Post / User | belongsTo | A comment row holds both `post_id` and `user_id` |
| User → Comment | hasMany | One resident can comment many times |
| Post ↔ Tag | belongsToMany | Many-to-many, so neither table can hold the key. The `post_tag` pivot (alphabetical name, composite primary key) holds both |
| Author → Comment | hasManyThrough | Comments have no `author_id`, but they belong to posts that belong to authors. Used for "N comments received" on the author page |

## Eager loading

`Model::preventLazyLoading()` is on outside production, so any missed
relation throws an error instead of running hidden queries. The index uses
`with(['author', 'tags'])->withCount('comments')`, the show page uses
`load(['author', 'tags', 'comments', 'comments.user'])`, and the author page
uses `loadCount('comments')` through the hasManyThrough.

## Validation

All input goes through Form Requests: `StoreCommentRequest`,
`StorePostRequest`, and `LoginRequest` (I moved my Lab 9 login validation
into one so no controller calls `$request->validate()`).

## How to run it

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run dev
php artisan serve
```

If `database/database.sqlite` doesn't exist, create it first
(`New-Item database/database.sqlite` in PowerShell). Run `npm run dev` and
`php artisan serve` in separate terminals, then open http://127.0.0.1:8000.