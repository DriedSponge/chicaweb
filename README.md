# Archived
I decided to stop working on this project because I feel my time is better spent on actual projects that might get used
or that will be useful. I made the typical developer mistake of coming up with a great idea without actually taking
into consideration how long it would take a solo dev to finish. With my more limited time, I would prefer to work on 
smaller projects that can be more "complete". Maybe I will return to this if I build out the accompanying bot. For now,
it's time to say good night.

These are some cool things I learned about while working on this that I hope to use in other projects:

- Laravel form precognition, works great with inertia vue.
- Inertia data sharing with laravel.
- Queues/Jobs, different types of workers.
- Redis caching can be very helpful!
- AWS S3 integration, with file permissions and signed URLs.
- Laravel policies for controlling what a user can do to a certain resource. 
- Custom artisan commands (super useful)!
- Auth/Permission guards/gates, using things like `can`.
- Custom middleware!

# Chica Bot Web

### About
This is the web panel for my Discord bot [Chica](https://github.com/driedsponge/chica).

It is made using Laravel, Vue, Tailwind, and InertiaJS to tie it all together.

It is still a work in progress, and is nowhere near finished. The end goal is to have a web space where users can see all the memes they have created in their servers.

### Custom Artisan Commands

- `app:set-admin {discordID}` - Sets the user as an admin for the web panel. You can add the `--revoke` flag to revert
to a normal user.
