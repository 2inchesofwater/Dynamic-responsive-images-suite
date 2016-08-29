# Dynamic-responsive-images-suite
A set of functions to convert a single image URL into a set of media query-friendly URLs

The solution scales the web development stack. It stretches from the CMS admin interface (Joomla, in this case), down to the server where Grunt processes the images using GraphicsMagick, then into PHP (in the form of module overrides for Joomla), and finally rendered into HTML and CSS.

The PHP file contains a short list of constants; their values are paired to the media query breakpoints held as variables in SCSS. 

Media queries
PHP

define("SCREEN_XS", "480");
define("SCREEN_SM", "768");
define("SCREEN_MD", "1024");
define("SCREEN_LG", "1400");
These constants are based on media query breakpoints.

SCSS

$screen-xs: 480px;
$screen-sm: 768px;
$screen-md: 1024px;
$screen-lg: 1400px;
These constants are based on media query breakpoints.

Image resizing
A second set of constants which control the image resizing. There's a set of folders in Joomla's images directory, paired to values within the site's gruntfile.js manifest.

Grunt

600px
800px
1400px
2000px
These constants are conveniently larger than the media query breakpoints. 

Joomla images folder

/600px
/800px
/1400px
/2000px
/Upload_2000px
To start the process, a content production team user uploads an image into the Upload_2000px folder. The user inserts a link to an image in the Upload_2000px folder into their document.

Grunt.js watches that folder and when it detects a new file, it instructs GraphicsMagick to clone and resize the image into the other folders. 

The CMS holds a single simple reference to the Upload_2000px image in the CMS' database. 

The actual PHP functions are quite simple - just string replace and concatenation to construct a valid HTML5 picture element (or img element) when requested by the site's front-end.

A content production team member can still provide an art-directed image, if necessary. They can directly overwrite an image saved in the /600px folder, for example.

Example.
The following code can be placed inside a Joomla module override file. As such, the actual functions are written in PHP.

<picture>

<?php echo createPictureSources(htmlspecialchars($images->image_intro), "1400px, 800px, 600px"); ?>

<?php echo createImageSrc(htmlspecialchars($images->image_intro), "600px", "", $item->title); ?>

</picture>

You'll notice there are two functions - createPictureSources and createImageSrc. The output syntax is sufficiently different between the two to warrant separate functions.

A similar function also helps with the site’s logo - it receives a URL for an image and seeks a .svg in the same location. 

Future.
Refinement of this responsive images workflow could include the following:

Increase consistency of syntax across the family of functions
Complete documentation of the functions
Consistent application of class and alt text across all functions
Better bulletproofing of code
Expand functions to handle retina images, and emerging formats such as .webp
Complete re-write of PHP functions into Joomla (or equivalent CMS) plugin architecture
