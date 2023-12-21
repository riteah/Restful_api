# Restful_api
1. Create a new student record
Endpoint: POST /index.php/student
Parameters:
name (string): Student's name.
age (integer): Student's age.
grade (string): Student's grade.
address (string): Student's address.
Example
bash
Copy code
curl -X POST -d "name=John&age=20&grade=A&address=123 Main St" <project_url>/index.php/student
2. Update an existing student record
Endpoint: PUT /index.php/student
Parameters:
id (integer): Student ID.
name (string): Updated student name.
age (integer): Updated student age.
grade (string): Updated student grade.
address (string): Updated student address.
Example
bash
Copy code
curl -X PUT -d "id=1&name=UpdatedName&age=22&grade=B&address=456 New St" <project_url>/index.php/student
3. Delete a student record
Endpoint: DELETE /index.php/student
Parameters:
student_id (integer): ID of the student to be deleted.
Example
bash
Copy code
curl -X DELETE -d "student_id=1" <project_url>/index.php/student
4. List all student records
Endpoint: GET /index.php/student
Example
bash
Copy code
curl <project_url>/index.php/student
Response Format
The API returns JSON responses in the following format:

Success Response:
json
Copy code
{
  "status": 1,
  "message": "Operation successful",
  "data": { /* Response data */ }
}
Error Response:
json
Copy code
{
  "status": 0,
  "message": "Error message",
  "data": null
}
Installation and Configuration
Clone the repository.
Set up the CodeIgniter framework.
Configure the database settings in config/database.php.
Run the API using a web server (e.g., Apache).
Access the API endpoints using the provided examples.
Feel free to contribute and extend the functionality of this basic student management API!
