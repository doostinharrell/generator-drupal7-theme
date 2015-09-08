/**
 * Table of Contents
 *
 * 1. Layout Overview
 * 2. Layout Rules
 * 3. Layout Examples
 */


/**
 * 1. Layout Overview
 */

Layout rules divide the page into sections.
Layouts hold one or more modules together.


/**
 * 2. Layout Rules
 */

CSS, by its very nature, is used to lay elements out on the page.
However, there is a distinction between layouts dictating the major
and minor components of a page. The minor components—such as a callout,
or login form, or a navigation item—sit within the scope of major
components such as a header or footer. I refer to the minor components
as Modules and will dive into those in the next section. The major
components are referred to as Layout styles.

Layout styles can also be divided into major and minor styles based on
reuse. Major layout styles such as header and footer are traditionally
styled using ID selectors but take the time to think about the elements
that are common across all components of the page and use class selectors
where appropriate.

// Layout declarations
#header, #article, #footer {
  width: 960px;
  margin: auto;
}

#article {
  border: solid #CCC;
  border-width: 1px 0 0;
}

Some sites may have a need for a more generalized layout framework (for
example, 960.gs). These minor Layout styles will use class names instead
of IDs so that the styles can be used multiple times on the page.

Generally, a Layout style only has a single selector: a single ID or class
name. However, there are times when a Layout needs to respond to different
factors. For example, you may have different layouts based on user preference.
This layout preference would still be declared as a Layout style and used in
combination with other Layout styles.

// Use of a higher level Layout style affecting other Layout styles.
#article {
  float: left;
}

#sidebar {
  float: right;
}

.l-flipped #article {
  float: right;
}

.l-flipped #sidebar {
  float: left;
}

In the Layout example, the .l-flipped class is applied on a higher level
element such as the body element and allows the article and sidebar content
to be swapped, moving the sidebar from the right to the left and vice versa
for the article.

// Using two Layout styles together to switch from fluid to fixed layout.
#article {
  width: 80%;
  float: left;
}

#sidebar {
  width: 20%;
  float: right;
}

.l-fixed #article {
  width: 600px;
}

.l-fixed #sidebar {
  width: 200px;
}

In this last example, the .l-fixed class modifies the design to change the
layout from fluid (using percentages) to fixed (using pixels).

One other thing to note in the Layout example is the naming convention that
I have used. The declarations that use ID selectors are named accurately and
with no particular namespacing. The class-based selectors, however, do use an
l- prefix. This helps easily identify the purpose of these styles and separate
them from Modules or States. Layout styles are the only primary category type
to use ID selectors, if you choose to use them at all. If you wish to namespace
your ID selectors, you can, but it is not as necessary to do so.

Using ID selectors
To be clear, using ID attributes in your HTML can be a good thing and in some
cases, absolutely necessary. For example, they provide efficient hooks for
JavaScript. For CSS, however, ID selectors aren’t necessary as the performance
difference between ID and class selectors is nearly non-existent and can make
styling more complicated due to increasing specificity.


/*
 * 3. Layout Examples
 * /

See: https://smacss.com/book/type-layout