# BLUEPRINT — Jelajah Madura

> Permanent architectural memory. Updated as the project evolves.  
> Last full audit: 2026-08-01

---

## Project Overview

**Jelajah Madura** is a tourism content-management platform for **Madura Island, Indonesia** (four regencies: Bangkalan, Sampang, Pamekasan, Sumenep). It is a **community-driven** system where contributors submit tourism/culinary/UMKM/photo-spot content, admins moderate and publish it, and visitors browse, search, and explore approved content.

- **Context**: Built for the **IT-FEST Software Development 2026** competition.
- **Main purpose**: Digital tourism platform — explore, contribute, moderate.
- **Domain language**: Indonesian (UI text, comments, variable names in some places).

### Main Technologies

| Layer | Technology | Version |
|-------|-----------|---------|
| Runtime | **PHP** | 8.3+ |
| Backend | **Laravel Framework** | 13.15.0 |
| Database | **MySQL** (database: `jelajah_madura`) | 8.x+ |
| Frontend | **Blade** templates + **Tailwind CSS** + **Alpine.js** (CDN) | — |
| Build tool | **Vite** with `@tailwindcss/vite`, `laravel-vite-plugin` | 8.x |
| Node.js | Required for asset compilation | 20+ |
| Icons | **Lucide** (CDN UMD) + `blade-lucide-icons` (server-side) | — |
| Fonts | **Satoshi** (Fontshare) + **Instrument Sans** (Bunny via Vite) | — |
| Sessions/Cache/Queue | All backed by **database** (MySQL) driver | — |
| Image processing | **GD** (native PHP extension) — resize max 1600px, 80% WebP | — |
| UI Notifications | Custom **AlpineJS Toast** component + **Confirm Modal** | — |

### System Requirements (Deployment)

| Requirement | Minimum |
|-------------|---------|
| PHP | 8.3 with extensions: `gd`, `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json` |
| Composer | 2.x |
| Node.js | 20+ (for `npm run build` during deployment) |
| MySQL | 8.0+ (or MariaDB 10.3+) |
| Disk Space | ~200MB (application) + storage for uploaded images |
| Web Server | Nginx (recommended) or Apache with `mod_rewrite` |

### Quick Start (Local Development)

```bash
# 1. Clone & install
git clone https://github.com/kaz-hero123/IT-FEST-Software-Dev-2026.git
cd IT-FEST-Software-Dev-2026
composer install
npm install

# 2. Environment setup
cp .env.example .env
php artisan key:generate

# 3. Database (MySQL)
# Buat database 'jelajah_madura' di MySQL terlebih dahulu
# Sesuaikan DB_USERNAME dan DB_PASSWORD di .env
php artisan migrate --seed

# 4. Storage link (for uploaded images)
php artisan storage:link

# 5. Run development server
php artisan serve    # Backend at http://127.0.0.1:8000
npm run dev          # Vite dev server for HMR
```

### Production Build

```bash
# Build frontend assets for production
npm run build

# Optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## Workspace Structure

```
├── app/
│   ├── Console/Commands/         # Artisan commands (OptimizeCultureImages)
│   ├── Http/
│   │   ├── Controllers/          # Public + contributor controllers
│   │   │   └── Admin/            # Admin-only controllers
│   │   ├── Middleware/           # EnsureAdmin, EnsureContributor
│   │   └── Requests/             # Form request validation
│   │       ├── Admin/            # RejectContentRequest, UnpublishContentRequest
│   │       ├── Auth/             # LoginRequest, RegisterRequest
│   │       └── Content/          # StoreContentRequest, UpdateContentRequest
│   ├── Models/                   # Eloquent models (7 total)
│   └── Providers/                # AppServiceProvider (empty boot)
├── bootstrap/app.php             # Middleware aliases + guest redirect logic
├── config/                       # Standard Laravel config files
├── database/
│   ├── factories/                # Content, Photo, User factories
│   ├── migrations/               # 12 migrations
│   └── seeders/                  # 8 seeders (curated + faker data)
├── public/
│   ├── images/                   # Static images (culture/, dashboard, etc.)
│   └── js/chat-support.js        # Alpine.js chat widget + admin chat center
├── resources/
│   ├── css/app.css               # Tailwind import + typing cursor animation
│   ├── js/
│   │   ├── app.js                # Typewriter, parallax scroll, FAQ scrollspy
│   │   └── auth.js               # Login/register panel slide animation
│   └── views/
│       ├── auth/                 # login.blade.php, register.blade.php
│       ├── components/           # Shared: navbar, footer, sidebar, admin-chat, etc.
│       ├── layouts/              # layout.blade.php (public), admin-layout.blade.php
│       └── pages/
│           ├── admin/            # Admin dashboard, moderation, content mgmt, chat
│           ├── contributor/      # Contributor dashboard, create/edit forms
│           └── user/             # Home, explore, search, about, FAQ/question
├── routes/web.php                # All route definitions
├── tests/                        # Feature + Unit (default Laravel scaffold)
└── vite.config.js                # Vite configuration
```

### Directory Responsibilities

| Directory | Responsibility |
|-----------|---------------|
| `app/Models/` | Domain entities: User, Content, Category, Regency, Photo, ChatMessage, ModerationNote |
| `app/Http/Controllers/` | Public pages (Landing, Explore, Search), contributor CRUD (Content, Dashboard) |
| `app/Http/Controllers/Admin/` | Admin pages: dashboard, moderation workflow, content management, chat |
| `app/Http/Middleware/` | Role-based access control (admin vs. contributor) |
| `app/Http/Requests/` | Centralized validation rules per form |
| `database/seeders/` | Curated Madura tourism data (Wisata, Kuliner, UMKM, Spot Foto) + faker generation |
| `public/js/` | Chat support (Alpine.js components for user widget + admin dashboard) |
| `resources/js/` | Vite-bundled JS: typewriter, parallax, scrollspy, auth animations |
| `resources/views/components/` | Reusable Blade components (navbar, footer, sidebar, eco-tips, FAQ accordion, modals) |
| `resources/views/pages/` | Three audience areas: `user/`, `contributor/`, `admin/` |

---

## System Architecture

### Three-Tier User System

```
┌──────────────────────────────────────────────────────┐
│                    VISITORS (unauthenticated)         │
│  Browse home, explore regencies, view content, search │
│  Use floating chat widget                             │
└──────────────┬───────────────────────────────────────┘
               │ Register / Login
┌──────────────▼───────────────────────────────────────┐
│                 CONTRIBUTORS (role=contributor)        │
│  Dashboard (stats), create/edit/delete own content    │
│  Content goes to "pending" on create/edit             │
└──────────────────────────────────────────────────────┘
               │ Separate login (/admin/login)
┌──────────────▼───────────────────────────────────────┐
│                    ADMINS (role=admin)                 │
│  Dashboard (global stats), moderation queue,          │
│  approve/reject/unpublish/delete content,             │
│  live chat center, content management                 │
└──────────────────────────────────────────────────────┘
```

### Major Components

1. **Public Frontend** — Landing page with popular destinations, explore by regency, content detail pages, search, about, FAQ.
2. **Contributor Portal** — Dashboard with content stats (approved/pending/rejected), create/edit forms with image upload, content deletion.
3. **Admin Portal** — Separate layout with sidebar navigation. Moderation queue, content management, live chat dashboard.
4. **Chat System** — Polling-based live chat. User-side widget (floating bubble) and admin-side conversation center. Uses `session_id` in localStorage to identify anonymous visitors. Protected by API rate limiting (`throttle:120,1`). Admin persona is **"Rara"** with auto-reply capabilities.
5. **Image Pipeline** — Uploaded photos are resized (max 1600px width) and converted to WebP (80% quality) using GD.
6. **Notification System** — Global AlpineJS Toast component (`<x-toast />`) injected in all layouts. Automatically catches Laravel flash sessions (`success`, `error`) and validation errors.

### How Components Connect

- **Routes** → `bootstrap/app.php` registers middleware aliases (`contributor`, `admin`).
- **Middleware** gates access: `auth` + `contributor` for contributor routes, `auth` + `admin` for admin routes. Guest redirect sends admin routes to `/admin/login`, others to `/login`.
- **Blade layouts**: Public pages extend `layouts/layout.blade.php`; admin pages extend `layouts/admin-layout.blade.php`.
- **API endpoints** (`/api/chat/*`) are unauthenticated, used by Alpine.js chat components via `fetch()` polling.
- **Content model** is the central entity — it connects to User, Category, Regency, Photos, and ModerationNotes.

---

## Feature Map

### Public Features
- **F-01** Landing page with popular destinations (top 6 by view_count) and **YouTube video promotion**
- **F-02** Explore page — browse by regency (shows approved content count)
- **F-03** Regency detail page — filter by category, search within regency, paginated (12/page)
- **F-04** Content detail page — photo gallery, description, address, maps URL, open/close times, related content (same category+regency, max 4)
- **F-05** Global search — searches title, description, address; min 2 chars; filterable by category
- **F-06** About page with mission/values/how-it-works sections
- **F-07** FAQ page with scrollspy navigation
- **F-08** User live chat widget (floating bubble, anonymous via localStorage session)
- **F-09** View count tracking (increment on each content detail visit)

### Contributor Features
- **F-10** Registration (name, email, password with confirmation; role auto-set to `contributor`) & Password Reset Flow (Forgot/Reset Password).
- **F-11** Login with session regeneration; admin role redirected to `/admin/dashboard`
- **F-12** Contributor dashboard — stats cards (approved/pending/rejected) + paginated content list with moderation note display
- **F-13** Create content — title, description, category, regency, address, maps URL, open/close times, 1-5 photos (jpg/jpeg/png/webp, max 5MB each)
- **F-14** Edit content — same fields; status resets to pending on update; max 5MB per photo validation on both client and server (replaces all if provided), status reset to `pending`
- **F-15** Delete content (soft delete via `softDeleteWithStatus()`)
- **F-16** Ownership enforcement — 403 if editing/deleting content not owned by current user

### Admin Features
- **F-17** Separate admin login page (`/admin/login`) — role check after auth, non-admin logged out
- **F-18** Admin dashboard — global stats (total/pending/approved/rejected) + 5 recent pending
- **F-19** Moderation queue — filterable by status (pending/approved/rejected/all), searchable by title or contributor name
- **F-20** Moderation detail — view all photos, metadata, full moderation history
- **F-21** Approve content — sets `status=approved`, `was_approved=true`, logs moderation note
- **F-22** Reject content — requires note (10-1000 chars), sets `status=rejected`, logs moderation note
- **F-23** Content management — list approved content, unpublish (back to pending with required note), delete (soft)
- **F-24** Admin live chat center — view all conversations, reply as "Rara", canned templates, auto-replies, clear chat, unread badges
- **F-25** Moderation audit trail — every approve/reject/unpublish/delete is logged to `moderation_notes`

### UI/UX Features
- **F-26** Parallax scroll effect on banner images
- **F-27** Typewriter animation on hero text (configurable speed, phrases, loop)
- **F-28** Eco-tips component
- **F-29** Confirm modal component (reusable for delete/unpublish actions)
- **F-30** Auth page slide animation — login and register share a page with a sliding banner panel
- **F-31** Responsive admin sidebar — collapsible on mobile with overlay

---

## Data Flow

### Content Lifecycle

```
Contributor creates content
        │
        ▼
  Status: PENDING  ─────────────────────┐
        │                                │
   Admin reviews                    Contributor edits
        │                          (resets to PENDING)
   ┌────┴────┐
   │         │
APPROVE    REJECT (with note)
   │         │
   ▼         ▼
APPROVED   REJECTED
   │         │
   │    Contributor edits
   │    (resets to PENDING)
   │
Admin can UNPUBLISH (back to PENDING, was_approved stays true)
Admin can DELETE (soft delete, status='deleted')
Contributor can DELETE own content (soft delete)
```

### Image Upload Flow

```
User uploads JPG/JPEG/PNG/WebP (max 2MB each, 1-5 files)
     │
     ▼
processAndStoreImage() — GD library
     │
     ├── Resize to max 1600px width (maintain aspect ratio)
     ├── Convert to WebP at 80% quality
     ├── Save to: storage/app/public/contents/{content_id}/{unique}.webp
     └── Fallback: if GD fails, store original via Laravel Storage
     │
     ▼
Photo record created in DB (file_path = relative path, is_primary for first photo)
```

### Chat Flow

```
Visitor opens chat widget → localStorage generates session_id
     │
     ├── GET /api/chat/messages?session_id=xxx → returns messages (auto-creates welcome if empty)
     ├── POST /api/chat/send → stores message (validated: session_id, sender_name, sender_type, message)
     └── Polling every 5 seconds (user) / 2.5 seconds (admin)
     │
Admin chat center:
     ├── GET /api/chat/admin/conversations → aggregates all sessions
     ├── POST /api/chat/send (sender_type=admin, sender_name=Rara)
     └── POST /api/chat/clear → deletes session messages + creates new welcome
```

---

## Important Files

| File | Role |
|------|------|
| `bootstrap/app.php` | Middleware registration + guest redirect logic |
| `routes/web.php` | All route definitions — the roadmap of the app |
| `app/Models/Content.php` | Central entity with relationships, slug routing, moderation helpers, soft delete |
| `app/Http/Controllers/ContentController.php` | Public show + contributor CRUD + image processing |
| `app/Http/Controllers/Admin/ModerationController.php` | Core moderation workflow (approve/reject) |
| `app/Http/Controllers/ChatApiController.php` | All chat API endpoints |
| `public/js/chat-support.js` | Alpine.js chat components (user widget + admin center) |
| `resources/js/app.js` | Typewriter, parallax, scrollspy — the animation engine |
| `resources/views/layouts/layout.blade.php` | Public page shell (loads CDNs, parallax, footer, chat widget) |
| `resources/views/layouts/admin-layout.blade.php` | Admin page shell (sidebar, mobile nav) |
| `database/seeders/DatabaseSeeder.php` | Seeder order — regencies → categories → users → curated content → faker |
| `database/seeders/WisataSeeder.php` | Curated Madura tourism data with real place names |

---

## Business Rules

### Authentication & Authorization
- Users register as `contributor` by default. There is no self-registration as admin.
- Two user roles exist: `contributor` and `admin`. Enforced via `EnsureContributor` and `EnsureAdmin` middleware.
- Admin login has a **separate entry point** (`/admin/login`). If a non-admin authenticates there, they are immediately logged out.
- Guest redirect is context-aware: admin routes → `/admin/login`, other routes → `/login`.
- Login and registration are rate-limited to 6 attempts per minute (`throttle:6,1`).
- Content store is also rate-limited (`throttle:6,1`).

### Content Rules
- Content uses **slug-based routing** (not IDs). Slugs are auto-generated from title, uniqueness enforced (including soft-deleted records).
- Only **approved** content is visible to the public. Cross-regency access is blocked (content must belong to the regency in the URL).
- When a contributor **edits** content, status is **always reset to `pending`** — requires re-moderation.
- `was_approved` flag tracks if content was **ever** approved (survives unpublish).
- **Soft deletes** are used. `softDeleteWithStatus()` sets `status='deleted'` before calling `delete()`.
- Contributors can only edit/delete **their own** content (enforced via `authorizeOwner()`, 403 on violation).

### Photo Rules
- **1 to 5 photos** required on create; **optional** on update.
- When new photos are uploaded during update, **all old photos are replaced** (storage files deleted + DB records deleted).
- First uploaded photo is automatically marked `is_primary=true`.
- Allowed formats: `jpg, jpeg, png, webp`. Max size: `2048 KB` per image.
- Images are processed to **WebP format**, max **1600px width**, **80% quality**.
- `Photo.resolvedUrl` accessor handles two path formats: `images/` prefix (static/seeded) uses `asset()`, others use `Storage::url()`.

### Moderation Rules
- **Reject** and **unpublish** both require a note (10-1000 chars).
- **Approve** does not require a note.
- Every moderation action (approved/rejected/unpublished/deleted) is logged to `moderation_notes` with admin_id, action, optional note, and timestamp.
- `Content.logModeration()` centralizes this logging.

### Chat Rules
- Chat is **unauthenticated** — anyone can chat without logging in.
- Session identity is stored in **localStorage** (key: `jelajah_madura_visitor_session_id`).
- If no messages exist for a session, a **welcome message** is auto-created from "Rara" (admin persona) with auto-reply behavior.
- Clearing chat deletes all messages for that session and recreates the welcome.
- Polling stops after **5 consecutive fetch errors** (user widget).
- Admin sees **unread count** based on trailing user messages.

### Search Rules
- Global search requires **minimum 2 characters**.
- Searches title, description, and address fields with LIKE queries.
- Category filter is optional, applied via slug.
- Explore page search filters title and description within a specific regency.

### View Count
- Incremented on **every** content detail page visit (no deduplication).
- Indexed for performance.

---

## Coding Conventions

### PHP / Laravel
- **Laravel 13** with attribute-based model configuration (`#[Fillable]`, `#[Hidden]` on User model). Other models use `$fillable` property.
- **Form Request classes** for all write operations (no inline validation in controllers).
- **Soft deletes** on Content only.
- **No timestamps** on lookup tables (Category, Regency, Photo, ModerationNote).
- Comments are a mix of **Indonesian** and **English**. Business-facing comments tend to be Indonesian.
- Controller naming: public/contributor in `Controllers/`, admin in `Controllers/Admin/`.
- Route model binding uses **slug** for Content and Regency (via `getRouteKeyName()`).
- Eloquent relationships follow Laravel convention. Custom foreign key on `ModerationNote.admin_id`.
- Feature codes referenced in comments (e.g., `F-04`, `F-05`, `F-06`, `F-07a`).

### Frontend / Blade
- Views are organized by audience: `pages/user/`, `pages/contributor/`, `pages/admin/`.
- Naming convention: `{audience}-{page}-{section}.blade.php` (e.g., `user-home-hero.blade.php`).
- **Tailwind CSS via CDN** (not the Vite plugin build for views) — the layout loads `cdn.tailwindcss.com`.
- **Alpine.js via CDN** with `defer` — used for interactive components (chat, FAQ, typewriter).
- Shared components use Blade's `<x-component />` syntax (e.g., `<x-footer />`, `<x-admin-chat />`).
- Layout uses `@yield` / `@section` pattern (not Blade components for layout).

### JavaScript
- `resources/js/app.js` — Vite-bundled, exports to `window.*` for global access.
- `public/js/chat-support.js` — loaded synchronously via `<script src>` (not Vite-bundled).
- Alpine.js data functions registered on `window` object.
- No framework (React, Vue, etc.) — pure vanilla JS + Alpine.js.

### Database
- MySQL with foreign key constraints and cascade deletes.
- Indexes on `contents.status` and `contents.view_count`.
- Content status enum: `pending`, `approved`, `rejected`, `deleted`.
- User role enum: `contributor`, `admin`.
- Chat uses string `session_id` (not foreign key to users).

---

## 🟢 Validated Features (Testing Checklist)

All features below have been manually verified to work end-to-end:
1. **Authentication**: Contributor registration, separate login gateways, rate limiting (429 modal), and password resets.
2. **Content Lifecycle**: Creation (pending), Admin Approval/Rejection/Unpublishing with moderation notes, and soft-deletions. Ownership is strictly enforced (403).
3. **Image Uploads**: Validated size limits (5MB) and type enforcement. Correct conversion to WebP and 1600px resizing.
4. **Explore & Search**: Accurate regency filtering, category filtering, cross-regency protection (404), global search, and related content matching.
5. **Chat System**: Floating widget, real-time polling, and admin chat center working flawlessly with "Rara" persona.
6. **Mobile UI**: Forms and auth layouts switch correctly and responsively.

---

## Resolved Architectural Debt (Historical)
- **Tailwind Dual Loading**: Fixed (now strictly using Vite built CSS instead of CDN + Vite overlap).
- **Password Resets**: Fully implemented via `PasswordResetController`.
- **Missing Asset Links on Deploy**: Fixed by forcing HTTPS in `AppServiceProvider` for production environments (Railway).
- **Database**: Migrated fully from SQLite to MySQL.

---


---

## Testing Checklist

> Items verified manually by the user. All tests passed successfully.

### Authentication
- [x] **Register a new contributor**: Go to `/register`, fill name/email/password/confirm. Expect redirect to `/dashboard` and role = contributor in DB.
- [x] **Login as contributor**: Go to `/login`, enter contributor credentials. Expect redirect to `/dashboard`.
- [x] **Login as admin via regular login**: Use admin credentials at `/login`. Expect redirect to `/admin/dashboard` (not `/dashboard`).
- [x] **Admin login gate**: Go to `/admin/login`, enter contributor credentials. Expect error "Akses ditolak" and immediate logout.
- [x] **Rate limiting**: Submit login form 7+ times rapidly. Expect throttle (429 Too Many Requests).
- [x] **Guest middleware**: Visit `/dashboard` without login. Expect redirect to `/login`.
- [x] **Guest middleware (admin)**: Visit `/admin/dashboard` without login. Expect redirect to `/admin/login`.

### Content Lifecycle
- [x] **Create content**: As contributor, create with title, description, category, regency, 1-5 photos. Expect status=pending in DB. Expect redirect to `/dashboard` with success message.
- [x] **View pending content publicly**: Try to access a pending content's URL directly. Expect 404.
- [x] **Admin approve**: As admin, approve a pending content. Expect status=approved, was_approved=true, moderation note logged.
- [x] **Public visibility after approval**: Visit the content's URL. Expect 200 with full detail page.
- [x] **View count increment**: Visit content detail page, check `view_count` in DB. Visit again, confirm increment.
- [x] **Edit content as contributor**: Edit approved content. Expect status reset to pending. Expect new photos to replace old ones (if uploaded).
- [x] **Reject content**: As admin, reject with note. Expect status=rejected, note stored.
- [x] **Unpublish content**: As admin, unpublish approved content with note. Expect status=pending, was_approved still true.
- [x] **Delete content (contributor)**: Delete own content. Expect soft delete (deleted_at set, status='deleted').
- [x] **Delete content (admin)**: Delete from admin panel. Expect same soft delete + moderation note.
- [x] **Ownership enforcement**: As contributor A, try to edit contributor B's content. Expect 403.

### Image Upload
- [x] **Upload single photo**: Create content with 1 photo. Expect file stored as WebP in `storage/app/public/contents/{id}/`.
- [x] **Upload 5 photos**: Create content with 5 photos. Expect all stored, first is_primary=true.
- [x] **Upload oversized file**: Try uploading >2MB image. Expect validation error.
- [x] **Upload invalid format**: Try uploading a `.gif` or `.bmp`. Expect validation error.
- [x] **Photo display**: Confirm photos render correctly on content detail page (both seeded static paths and uploaded WebP).

### Explore & Search
- [x] **Explore index**: Visit `/explore`. Expect all 4 regencies displayed with approved content counts.
- [x] **Explore regency**: Visit `/explore/bangkalan`. Expect paginated approved content for Bangkalan.
- [x] **Category filter**: On regency page, filter by category slug. Expect only matching category content.
- [x] **Search within regency**: Use search input on regency page. Expect filtered results.
- [x] **Global search**: Visit `/search?q=pantai`. Expect approved content matching title/description/address.
- [x] **Search minimum length**: Search with 1 character. Expect no results returned.
- [x] **Related content**: On content detail page, confirm up to 4 related items (same category + same regency).

### Chat System
- [x] **Chat widget appears**: On any public page, confirm floating chat bubble in bottom-right.
- [x] **Open chat**: Click bubble. Expect welcome message from "Javier".
- [x] **Send message as visitor**: Type and send. Expect message appears in chat.
- [x] **Admin chat center**: As admin, visit `/admin/chat`. Expect conversation list with the visitor's session.
- [x] **Admin reply**: Select conversation, send reply. Expect message appears on visitor's widget (within 5s polling).
- [x] **Clear chat**: User clears chat. Expect new welcome message, old messages gone.
- [x] **Multiple sessions**: Open in two browsers. Expect independent sessions.

### Admin Dashboard
- [x] **Stats accuracy**: Verify total/pending/approved/rejected counts match actual DB data.
- [x] **Recent pending list**: Confirm shows up to 5 most recent pending items.

### Contributor Dashboard
- [x] **Stats accuracy**: Verify approved/pending/rejected counts are scoped to current user only.
- [x] **Moderation note display**: Confirm rejected content shows the latest rejection note.

### Landing Page
- [x] **Popular destinations**: Confirm top 6 by view_count are displayed.
- [x] **Typewriter animation**: Confirm hero text animates with typewriter effect.
- [x] **Parallax scroll**: Scroll down, confirm parallax effect on banner images.

### Cross-Regency Protection
- [x] **Wrong regency in URL**: Access `/explore/bangkalan/some-sumenep-content`. Expect 404.

---

## Open Questions

1. **No email verification**: `MustVerifyEmail` is commented out in User model. Is email verification intentionally skipped?
2. **Chat authentication**: Chat API endpoints are fully public (no auth middleware). Is this intentional? Any spam protection planned?
3. **Admin user creation**: There is no admin registration flow or artisan command to create admins. Admins are only created via seeders. Is there a planned admin management feature?
4. **Password reset**: `password_reset_tokens` table exists in migration but no password reset routes, controller, or views are implemented. Planned feature?
5. **Tailwind dual loading**: `resources/css/app.css` imports Tailwind via Vite plugin, but layouts also load Tailwind CDN via `<script src>`. This is redundant. Is the CDN intentional as the primary source while the Vite build is for something else?
6. **Double Vite import**: `layout.blade.php` calls `@vite(['resources/js/app.js'])` twice (lines 11 and 30). Likely unintentional.
7. **Static vs. uploaded photos**: Seeded content references static paths in `public/images/`, while user-uploaded content uses `storage/app/public/contents/`. The `Photo.resolvedUrl` accessor handles both, but the split may cause confusion.
8. **`replace_urls.php` and `test_rate_limit.php`**: Root-level PHP scripts exist. Are these development utilities that should be removed before production?
9. **FakerContentSeeder photo factory**: Uses `PhotoFactory` which generates placeholder URLs. Are these actually resolvable images or broken placeholders?
10. **No CSRF on chat API**: Chat endpoints at `/api/chat/*` do use CSRF tokens via the fetch header, but they're not behind the `api` middleware group. The `VerifyCsrfToken` middleware applies because they're web routes. Is this the intended configuration?
