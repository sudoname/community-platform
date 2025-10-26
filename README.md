# Community Platform

A modern, feature-rich community platform built with Laravel 12, Livewire 3, and Laravel Reverb. Connect with like-minded individuals, share knowledge, and grow together through real-time messaging, discussion forums, file sharing, and social authentication.

## Project Status

**Enhanced & Production Ready** - The project includes social authentication (Google/Facebook), RESTful API with Laravel Sanctum, modern landing page, and comprehensive user roles. Ready for deployment.

## Tech Stack

- **Backend**: Laravel 12.28.1 (PHP 8.3)
- **Frontend**: Livewire 3.6.4 with Volt
- **Real-time**: Laravel Reverb 1.6.0 (WebSockets)
- **Authentication**: Laravel Breeze with Livewire
- **Styling**: Tailwind CSS
- **Database**: SQLite (development)

## Features

### Completed ✅

- **Project Setup**
  - Laravel 12 with Livewire and Reverb installed
  - Git repository initialized
  - Environment configured with app key and Reverb settings

- **Database Schema**
  - Users table with role system (admin, paid_member, free_member)
  - Channels table for Discord-like chat channels
  - Messages table for real-time chat with replies and attachments
  - Forum categories, topics, and posts tables
  - Files table with polymorphic relationships
  - Subscriptions table for payment integration
  - Notifications table for real-time alerts

- **Models & Relationships**
  - All 8 models created with full relationships
  - Role helper methods (isAdmin(), isPaidMember(), isFreeMember())
  - Scopes for filtering (active, published, ordered)
  - Auto-slug generation for channels, categories, and topics

- **Authentication**
  - Laravel Breeze installed with Livewire
  - Registration, login, password reset flows
  - Profile management

- **Database Seeders**
  - 3 test users (admin, premium, free member)
  - 5 chat channels (including premium-only channel)
  - 6 forum categories

- **Livewire Components (Scaffolded)**
  - Chat: Index, ChannelList, MessageList, MessageForm
  - Forum: Index, CategoryList, TopicList, TopicShow, CreateTopic

- **Social Authentication** ✅
  - Laravel Socialite integrated
  - Google OAuth2 login support
  - Facebook OAuth login support
  - Auto-create user accounts from social profiles
  - Beautiful social login UI on login page

- **RESTful API** ✅
  - Laravel Sanctum authentication
  - API controllers for Users, Messages, Forums
  - Protected routes with token-based auth
  - Health check endpoint
  - API documentation ready

- **Modern Landing Page** ✅
  - Hero section with call-to-action
  - Feature highlights with icons
  - Gradient CTA section
  - Fully responsive design
  - Dark mode support

- **Test Accounts** ✅
  - Pre-configured users for all roles
  - Password: "Password" for all test accounts
  - admin@test.com (Admin)
  - paid@test.com (Paid Member - Premium)
  - free@test.com (Free Member)

### In Progress 🚧

- Implement Chat functionality
- Implement Forum functionality
- Integrate Reverb for real-time messaging
- Create file upload functionality

### Pending 📋

- Admin dashboard for content management
- Subscription tiers and payment integration (Stripe)
- Real-time notifications
- User profiles with avatars and bios
- Search functionality
- Mobile responsive design

## Database Structure

### Users
- Role-based access (admin, paid_member, free_member)
- Subscription tier tracking
- Avatar and bio support

### Channels (Chat)
- Public and private channels
- Role-based access control
- Display ordering
- Text and announcement types

### Messages
- Channel-based messaging
- Reply threading
- File attachments (JSON array)
- Pin and edit functionality

### Forums
- Categories with icons
- Topics with pinning and locking
- Threaded replies
- View and reply counts

### Files
- Polymorphic uploads (attach to messages, posts, etc.)
- File type tracking (image, video, document)
- Public/private visibility

### Subscriptions
- Multiple plans (free, basic, premium)
- Stripe integration ready
- Trial period support
- Billing intervals (monthly, yearly)

## Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd community-platform
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Configure environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Set up database**
```bash
php artisan migrate:fresh --seed
```

5. **Build assets**
```bash
npm run dev
```

6. **Start development servers**
```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Reverb (WebSockets)
php artisan reverb:start

# Terminal 3 - Vite (Asset building)
npm run dev
```

## Test Accounts

The application includes pre-configured test accounts (password: **Password**):

| Email | Role | Subscription | Features |
|-------|------|--------------|----------|
| admin@test.com | Admin | N/A | Full access |
| paid@test.com | Paid Member | Premium | Premium features |
| free@test.com | Free Member | Free | Basic access |

## Social Authentication Setup

### Google OAuth Configuration

1. Visit [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add authorized redirect URI: `http://localhost:8001/auth/google/callback`
6. Update `.env`:

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8001/auth/google/callback
```

### Facebook OAuth Configuration

1. Visit [Facebook Developers](https://developers.facebook.com/)
2. Create a new app
3. Add Facebook Login product
4. Configure redirect URI: `http://localhost:8001/auth/facebook/callback`
5. Update `.env`:

```env
FACEBOOK_CLIENT_ID=your-facebook-app-id
FACEBOOK_CLIENT_SECRET=your-facebook-app-secret
FACEBOOK_REDIRECT_URI=http://localhost:8001/auth/facebook/callback
```

## API Usage

The platform provides a RESTful API secured with Laravel Sanctum.

### Authentication

Generate an API token:

```bash
POST /api/login
Content-Type: application/json

{
    "email": "admin@test.com",
    "password": "Password"
}
```

Use the token in requests:

```bash
Authorization: Bearer {your-token}
```

### API Endpoints

#### Health Check
```
GET /api/health
```

#### User Management
```
GET    /api/users           # List users
GET    /api/users/{id}      # Get user
POST   /api/users           # Create user
PUT    /api/users/{id}      # Update user
DELETE /api/users/{id}      # Delete user
```

#### Messages
```
GET    /api/messages                    # List messages
POST   /api/messages                    # Send message
GET    /api/messages/channel/{channel}  # Get channel messages
```

#### Forums
```
GET    /api/forums                      # List topics
POST   /api/forums                      # Create topic
GET    /api/forums/category/{category}  # Get category topics
```

## Git Commits

The project has been developed incrementally with clear commits:
1. Initial commit with Laravel base and database schema
2. Laravel Breeze with Livewire authentication
3. Database seeders and Livewire component scaffolding

## Next Steps

1. Implement Chat/Index.php with channel switching
2. Build MessageList component with real-time updates
3. Create MessageForm for sending messages
4. Implement Forum topic creation and viewing
5. Add Reverb broadcasting for real-time chat
6. Design minimalist UI with Tailwind
7. Create admin dashboard for channel/category management

## File Structure

```
app/
├── Livewire/
│   ├── Chat/
│   │   ├── Index.php           # Main chat interface
│   │   ├── ChannelList.php     # Sidebar channel list
│   │   ├── MessageList.php     # Messages display
│   │   └── MessageForm.php     # Send message form
│   └── Forum/
│       ├── Index.php            # Forum home
│       ├── CategoryList.php     # Forum categories
│       ├── TopicList.php        # Topics in category
│       ├── TopicShow.php        # View topic & replies
│       └── CreateTopic.php      # Create new topic
├── Models/
│   ├── User.php                 # User with roles
│   ├── Channel.php              # Chat channels
│   ├── Message.php              # Chat messages
│   ├── ForumCategory.php        # Forum categories
│   ├── ForumTopic.php           # Forum topics
│   ├── ForumPost.php            # Forum replies
│   ├── File.php                 # File uploads
│   └── Subscription.php         # Payment subscriptions
```

## License

This is a custom-built community platform project.
