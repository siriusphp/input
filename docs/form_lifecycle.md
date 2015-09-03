---
title: A form's lifecycle
---

# A form's life-cycle

During its existence a form goes through a few stages.

### 1.Creation
**Sirius\Input\Input** forms have a few constructor dependencies (which have default values) but your application's forms might depend on other things. 

### 2. Initialization
The `init()` method doesn't do anything by default but you can use it for your application form to define the form's properties and elements. 
This is the place where you can add the logic that your form requires and must be retrieved from the dependencies (eg: set the values of a `<SELECT>` field from a database query).

The `init()` method is called automatically prior to preparation. So, if something wrong happens in your app, the (probably) expensive process of initializing the form will be skipped.

### 3. Preparation
At this point the form is prepared to accept data. The form's validator object is populated with rules from the elements' specs, the filtrator object has its filters configured (again, from the elements' specs) and upload handlers are configured.

The form's `prepare()` method is executed automatically before receiving data or rendering.

You can extend this method to alter the form in whatever way you want (add new elements, change elements, add custom validation rules, trigger events etc).

**Important!** While you can add/change/remove fields from a form after the preparation you must be aware that these changes will not propagate to the form's dependencies (filtrator/validator/upload handlers)

### 4. Receiving data
The `populate()` method is how the form gets data (`_POST` and `_FILES`). 
To process the data you need to call `isValid()` which will filter, validate and process the uploaded files. After this step we have:

1. Knowledge about the quality of the data (is the form valid?)
2. Access to the clean (filtered and validated) data that can be used by the system (to be persisted to a database or whatever).

### 5. Rendering
When it comes to flexible forms (eg: forms that are modified by plugins/events) this is the hardest part that are supposed to change their shape . While there are a lot of libraries that can help you with data filtering and validation you'll have a hard time finding a library that allows you to render complex forms with one line (Drupal is the only project that I found that can do that).

Rendering is handled by [Sirius\FormsRenderer](http://github.com/siriusphp/formsrenderer) because the **Sirius\Input** library can be used for handling incoming data that might not come from forms (eg: API calls).
