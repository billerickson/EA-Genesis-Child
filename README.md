[theme name] uses git for version control. Version control allows us to track codebase history, maintain parallel tracks of development, and collaborate without stomping out each other's changes.

We use the feature branches for active development, and the `master` branch for releases.

## Table of Contents
- [Structure](#structure)
- [Contribution Workflow](#contribution-workflow)
- [Initial Setup](#initial-setup)
- [Pushing changes to WPEngine](#pushing-changes-to-wpengine)
- [Pushing changes using DeployHQ](#pushing-changes-using-deployhq)

### Structure

#### Core Functionality plugin
Any functionality that is theme-independent belongs in the Core Functionality plugin. This includes registering custom post types, metaboxes, widgets... Anything a user would reasonably expect to still exist after changing themes. [More information.](http://www.billerickson.net/core-functionality-plugin/)

We're using [Carbon Fields](https://carbonfields.net/docs/) for metaboxes. The `ea_cf()` helper function is used to access this data. See `/plugins/core-functionality/inc/custom-fields-helper.php` for more information.

#### Theme
Any theme dependencies on functionality plugins should be built with the use of `do_action()` or `apply_filters()`.

**In short**, changing to the default theme should not trigger errors on a site. Nor should disabling a functionality plugin - every piece of code should be decoupled and use standard WordPress paradigms (hooks) for interacting with one another.


#### Code Compiling
We are using [CodeKit](https://codekitapp.com/) to compile and compress SCSS into minified CSS, and JS into a combined and minified JS file. You can use an alternative tool (ex: [Prepos](https://prepros.io/) or [gulp](http://gulpjs.com/)) but make sure to configure it to match the file organization below.

#### File Organization

Project structure unity across projects improves engineering efficiency and maintainability. We believe the following structure is segmented enough to keep projects organized—and thus maintainable—but also flexible and open ended enough to enable engineers to comfortably modify as necessary. All projects should derive from this structure:

```
|- assets/
|  |- images/ ____________________________ # Theme images
|  |- fonts/ _____________________________ # Custom/hosted fonts
|  |- icons/ _____________________________ # Icon font (see below)
|  |- js/
|    |- src/ _____________________________ # Source JavaScript
|    |- global-min.js ____________________ # Concatenated and Minified JavaScript
|  |- css/
|    |- main.css _________________________ # Concatenated and Minified CSS
|    |- editor-style.css
|  |- scss/ ______________________________ # See below for details
|- inc/ __________________________________ # PHP classes and files
|- partials/ _____________________________ # Template parts
|- templates/ ____________________________ # Page templates
```

The `scss` folder is described separately, below to improve readability. It is based on [How to structure a Sass project](http://thesassway.com/beginner/how-to-structure-a-sass-project):

```
|- assets/scss/
|-- modules/              # Common modules
|   |-- _helpers.scss     # Helper mixins
|   ...
|
|-- partials/             # Partials
|   |-- _base.scss        # global project variables + import modules and vendors
|   |-- _reset.scss       # Reset
|   |-- _icons.scss       # Icons
|   |-- _style-guide.scss # Main style guide for the site
|   ...
|
|-- vendor/                 # CSS or Sass from other projects
|   |-- _include-media.scss
|   |-- _bootstrap.scss     # Note that only some elements of bootstrap are included
|   ...
|
|-- main.scss            # primary Sass file for frontend
|-- editor-style.scss    # styles that apply only to backend editor
```

#### Icon Font
A custom icon font has been created using [IcoMoon](https://icomoon.io). A demo page showing all available icons is in /assets/icons/demo.html. To use an icon, add the appropriate class to an item (ex: `<i class="icon-facebook"></i>`).

To add additional icons:
1. Create a free account at [IcoMoon](https://icomoon.io).
2. Click "Manage Projects" ([screenshot](https://cl.ly/3y242K2j2243)), then click "New Project" at the bottom.
3. Click "Import Icons" in top left, and upload the file found in `/assets/icons/selection.json`. This will load all the current icons.
4. Click "Import Icons" and upload new icons. They should be a square, black and white SVG with no borders/outlines. If there's an issue with the file, IcoMoon will let you know. You can find icons at [The Noun Project](https://thenounproject.com/).
5. Once you've added your new icons, click "Generate Font" in bottom right corner, then click "Download". You'll get an `icomoon.zip` file.
6. Unzip this file, and rename the resulting directory to `icons`. Replace the `/assets/icons` directory in the repo with your new icons directory.
7. Copy the contents of `/assets/icons/style.css`, and paste in `/assets/scss/partials/_icons.scss`. Change the relative URL to the font files from `fonts/` to `../icons/fonts/`. This should be relative to the FINAL css file (`/assets/css/main.css`), not the SCSS partial.
8. Rebuild the site's stylesheet using your preferred tool (CodeKit, Prepos, grunt...).

### Contribution Workflow
1. Create an issue for your bug/feature if one doesn't already exist
2. Create a branch from `master` with the name matching the issue number (ex: `issue/101` branch)
3. Make your code changes to this branch
4. Submit a pull request describing the change and citing the original issue number.
5. If any changes are needed to your patch, make them to your branch and push up (`origin`). They will automatically appear in the pull request
6. Once the pull request is approved, the code will be merged into `master`. You may safely delete your branch

### Initial Setup

In your local environment, create a WordPress installation. Navigate to wp-content in terminal, then run (changing `your_name_here` to your username):
```
git init
git remote add origin git@github.com:billerickson/[theme-name].git
git pull origin master
```

Make sure you're on the `master` branch. You can check like this: `git status`

We're going to make a new branch of `master`. If your issue is #101, type the following:
```
git branch issue/101
git checkout issue/101
```

Make your code changes. When ready to push your commits to GitHub, type:
```
git push origin issue/101
```

Log into GitHub. You should see a notification at the top of the recently created branch. Click the button to "Compare & Create Pull Request" ([screenshot](https://cl.ly/2f1r1T2Z3Q3N)). Make sure to include the original ticket number in the title or description (ex: #101).

### Pushing changes to WPEngine

We use [WPEngine's git push](https://wpengine.com/git/) feature for pushing changes. First, provide your public key to a site administrator, so they can [give you git push access](https://wpengine.com/support/set-git-push-user-portal/). Then add the following remotes:

```
git remote add production git@git.wpengine.com:production/[theme-name].git
git remote add staging git@git.wpengine.com:staging/[theme-name].git
```

Once you've completed the Contribution Workflow above, you can push to production using: `git push production master`.  For feature branches that require review, it's recommended that you [Copy Live to Staging](https://wpengine.com/support/staging/), then push changes to staging: `git push staging master`. Once approved, these changes can be merged to master and pushed to production.

### Pushing changes using DeployHQ

If you are not using WPEngine, or are not comfortable with the command line, you can use [DeployHQ](https://www.deployhq.com/) instead. Set up a free account and configure two separate deployments: staging and production. I recommend setting them to manual, not automatic, as the free account is limited to 10 deployments per day.

1. Make changes to the site (either locally or using [GitHub visual editor](https://help.github.com/articles/editing-files-in-your-repository/)).
2. If editing locally, push those changes to GitHub: `git push origin master`
3. Log into DeployHQ and deploy those changes to staging.
4. View the staging site and make sure everything works.
5. Log into DeployHQ and deploy those changes to production.
