# 虫籠 (musikago)
Collect and kill bugs.

Local Test URL: http://localhost/WebProjects/musikago/

## Design

It should contain mainly three parts:

* USER: `users` registered would work after being related to one or more `projects`.
* PROJECT: a `project` is set for a group of `users` for a certain subject, where `issues` come out.
* ISSUE: an `issue` is a record for a certain bug, refinement, even question for a certain `project`, and be handled by `users` of this `project`.

For a little more details, 

* Users in any projects would have three kinds of roles (`admin`, `developer`,`reporter`) to make process go smoothly.
* Issues have a status circle, the items as `reported` -> `assigned` <-> `handled` -> `closed`, and a `closed` issue could be `reopened`, which would be treated as `reported`.
* Issues have a priority field as integer, by default this is from -2 (least priority) to 2 (most priority) and 0 is for common use.

### Model Outline

#### User

* user_id
* user_name
* display_name
* email
* password
* site_role // ADMIN or NULL

#### Project

* project_id
* project_name

#### User-Project Mapping

* project_id
* user_id
* role // admin, developer, reporter, disabled

#### Issue

* issue_id
* project_id
* report_user_id
* issue_title
* priority
* current_status

#### Event

* event_id
* issue_id
* user_id
* event_status
* description

#### Event Attributes

* attribute_id
* event_id
* key
* value

