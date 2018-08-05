## Ching's New Site

### Set-up notes

First do `npm install`, `composer install` (we don't use bower or anything else yet!)

1. Install a utility on your homestead box first simply by running `sudo apt-get install -y pv`
1. Study **.env.example** and copy to **.env** and make changes as needed
1. Need to copy Ching's old DB to database/database_old/ching_old.sql (can't put on github, its too big, but on Dropbox at **/Buildonauts Team/Projects/ChingHeHuang/OldDB/ching_old.sql**) - probably will need to create the folder too as it's in gitignore
1. Run `artisan key:generate`
1. Must run `artisan storage:link` if you want images to be generated and served via your local environment and **must** be run from within **homestead**. Otherwise you'll create a weird symlink to your local machine!
1. By default app will try to load images off local storage when not in production. In production (when we run on live server or test production mode, everything automatically starts going to the Rackspace CDN, all the images are already uploaded)
1. Then run `artisan migrate` followed by `artisan db:seed` - expect this to take a lot of time to run (500MB of DB to process)

---

### Important notes!

**User migration from old DB is not done yet although there is a schema ready for it, need to work with Hilton on the verifcation system and match up - 50,000 users to migrate**

Please try copying files into this set-up and don't mess around with any of the gulp, composer.json, package.json files. Speak to Craig first if they need changing. It took a long time to get this working just right! 

Image files put in the public directory for now but we'll move them over to the CDN probably.

I'm expecting mostly you just need to import in some view and controller files.

If we need to add dependencies let me know so Craig can help and we want to avoid bower (we can use composer or npm instead, as long as the project is github based)

I think tags were given up being used on blogs, by the look of it, but they are imported anyway.