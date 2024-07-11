### Home
- `/`

### About
- `/about`

### Contact
- `/contact`

### Game
- `/game`
  - Classic
    - `/game/classic` (Standard Wordle)
  - Classic Multiplayer
    - `/game/classic-mp/versus` (Who guesses the fastest)
    - `/game/classic-mp/coop` (Guess the word together)
  - Long
    - `/game/long` (Guess 7-letter words, 2 extra turns)
  - Long Multiplayer
    - `/game/long-mp/versus`
    - `/game/long-mp/coop`

### Auth
- `/auth`
  - Login
    - `/auth/login`
  - Register
    - `/auth/register`
  - Verify
    - `/auth/verify`
  - Blocked
    - `/auth/blocked`

### Account
- `/account`
  - Dashboard
    - `/account/` (Your account stats)
  - Friends
    - `/account/friends` (Your friends and your friend ID)
      - Add Friend
        - `/account/friends/add` (Based on username or friend ID)
      - Remove Friend
        - `/account/friends/remove`
  - Edit Profile
    - `/account/edit`
      - Edit Username
        - `/account/edit/username`
      - Edit Email
        - `/account/edit/email`
      - Edit Password
        - `/account/edit/password`

### Admin Panel
- `/account`
  - Dashboard
    - `/account/` (Site stats)
  - Users
    - `/account/users`
      - Edit User
        - `/account/users/edit` (Options for block and force verify)
      - Remove User
        - `/account/users/remove`
  - Games
    - `/account/games` (All games played)
