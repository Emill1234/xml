The project has the purpose of dealing with the manipulation of a XML document. In order to do so:

- XPath has been used for filtering and delet-ing/updating data
- XSLT for displaying results of these transformations (2 tables, student and timetable, respectively).

It can parse (in 2 ways, SimpleXML and DOM) and validate XML documents. It also has 2 APIs (web and REST, using GET and POST routes & the Laravel API) which can be used for changing data of a given course (updating nodes), adding and deleting students. Retrieval of data is also
available - one returns the timetable by department and year, and the other one returns the timetable by the first name and last name of the enrolled student.

The XML document and the XSD schema can be found in the storage/app folder. The XML contains a list of students, each one with a <student> tag, as well as <timetable> tags, each of them having department and year
attributes in order to be easily identified. The <student> tag has the following elements: firstName, lastName, studentNumber, faculty, department, yearofstudy, while each <timetable> has the attributes department and yearofstudy.
Each timetable has a <week> tag containing 4 (or less) <day> tags. For each day tag, we can have one or more classes. Classes are identified by type attribute, which could be either lecture or lab. Each class has a subjectName,
teacher, startTime and endTime, which are mandatory (minOccurs set to 1), and could have a weekParity element which is for determining whether labs are on even or odd weeks (optional, minOccurs set to 0). In the XSD file
there has been also taken care of the maxOccurs, which is unbounded for student, timetable and class.
