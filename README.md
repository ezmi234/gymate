# Web Developement Project - University of Bologna

# **GYMATE**

## Introduction
This project simulates a social media platform, where the purpose is to create connection between gym buddies where you can easily find you GymBro and follow his workouts.

## Instructions
Clone this repo and open an unix bash inside the `gymate` in  folder. 

Run the following commands:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

```bash
sudo chown -R $USER: .
```

```bash
cp .env.example .env
```

Open the `.env` file and change the following lines:
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=gymate
DB_USERNAME=sail
DB_PASSWORD=password
```

The first time you run the project, you need to run the following script:
```bash 
./start.sh
```

After that, you can run the project with the following script:
```bash
./start2.sh
```

## Basic Functionalities
### Login and Registration
It is possibile to register to *Gymate* with an **unique email** per user. The names are also required, as well as a password that will be safely stored in the mysql database.
Once a User is registered, it's possible to login with the provided email and the choosen password. Once the login is done
the homepage is shown.

### Profile
There are *two* types of profile:
- **Personal Profile**: your own profile where you can view post(workout) and interact with them, delete posts and edit your profile.
- **User Profile**: other users profiles, where you can view their post and interact with them. You can also follow/unfollow them.

#### Edit Profile
Once you have registered your account you will be redirected to the profile editing page where you can change your profile picture and bio. It can be accessed from the personal profile page too. Here you can edit your bio, profile picture and location.

#### Search Profiles
In the top searchbar, it's possible to search for a user by it's name. A list of the first 5 result is shown, and by clicking to one of the result, the page is redirected to the searched user profile's page. If you want to see all the results, you can click on the `Search` button.

### Timelines
There are *two* homes:
- **Home** where it is possible to see al posts of followed users only
- **Explore** where are shown future posts from people that the user might be interested in

To select one of the two, the navbar makes it easy to access them.

### Post Creation Editor
In your profile page you can also add a post click on the button `Add Workout`. Here you can add a title, a description, a date and a place for the event. You can also add a picture to the post. Once you have created a post you delete it.

### Post
When you enter a post you will be able to view or post comments regarding the post / workout. Inside a post there are informations regarding the number of likes and the number of participants the place and date of the event and a link to the profile of the creator. Here you can decide to participate or leave an workout.

### Notifications
Notifications are in real time, meaning that a long polling procedure retrieves new notifications every (worst case) 10 seconds.

A notification is sent to you if:
- Someone started following you.
- Someone liked your post.
- Someone commented your post.
- Someone is participating to one of your workouts.
- Someone left one of your workouts.

---

## Pros
- Mobile First Approach
- Responsive Design
- Use of **AJAX**
- Passwords encyption
- Real time notification updates
