-- Database: LibraryDB

-- Drop existing tables if they exist (for a fresh start)
DROP TABLE IF EXISTS BorrowingRecords;
DROP TABLE IF EXISTS Members;
DROP TABLE IF EXISTS Books;
DROP TABLE IF EXISTS Authors;

-- Create Authors table
CREATE TABLE Authors (
    AuthorID INT AUTO_INCREMENT PRIMARY KEY,  -- Primary Key
    FirstName VARCHAR(100) NOT NULL,
    LastName VARCHAR(100) NOT NULL,
    BirthDate DATE,
    UNIQUE (FirstName, LastName)  -- Unique constraint for author name combination
);

-- Create Books table
CREATE TABLE Books (
    BookID INT AUTO_INCREMENT PRIMARY KEY,  -- Primary Key
    Title VARCHAR(255) NOT NULL,
    AuthorID INT,  -- Foreign Key
    Genre VARCHAR(100),
    PublicationYear YEAR,
    ISBN VARCHAR(20) UNIQUE,  -- ISBN should be unique
    FOREIGN KEY (AuthorID) REFERENCES Authors(AuthorID)  -- Foreign Key constraint
);

-- Create Members table
CREATE TABLE Members (
    MemberID INT AUTO_INCREMENT PRIMARY KEY,  -- Primary Key
    FirstName VARCHAR(100) NOT NULL,
    LastName VARCHAR(100) NOT NULL,
    DateOfBirth DATE,
    Email VARCHAR(255) UNIQUE NOT NULL,  -- Unique Email constraint
    Phone VARCHAR(20)
);

-- Create BorrowingRecords table (Many-to-Many relationship between Books and Members)
CREATE TABLE BorrowingRecords (
    RecordID INT AUTO_INCREMENT PRIMARY KEY,  -- Primary Key
    MemberID INT,  -- Foreign Key
    BookID INT,  -- Foreign Key
    BorrowDate DATE NOT NULL,
    ReturnDate DATE,
    Status ENUM('borrowed', 'returned') DEFAULT 'borrowed',
    FOREIGN KEY (MemberID) REFERENCES Members(MemberID),  -- Foreign Key constraint
    FOREIGN KEY (BookID) REFERENCES Books(BookID)  -- Foreign Key constraint
);

-- Insert sample data into Authors table
INSERT INTO Authors (FirstName, LastName, BirthDate) VALUES
('John', 'Doe', '1970-05-15'),
('Jane', 'Smith', '1980-09-20'),
('Emily', 'Clark', '1990-02-28');

-- Insert sample data into Books table
INSERT INTO Books (Title, AuthorID, Genre, PublicationYear, ISBN) VALUES
('Introduction to PHP', 1, 'Programming', 2023, '978-1234567890'),
('Learning MySQL', 2, 'Databases', 2022, '978-0987654321'),
('Web Development Basics', 3, 'Web Development', 2021, '978-1122334455');

-- Insert sample data into Members table
INSERT INTO Members (FirstName, LastName, DateOfBirth, Email, Phone) VALUES
('Alice', 'Johnson', '1995-06-01', 'alice@example.com', '1234567890'),
('Bob', 'Williams', '1992-11-15', 'bob@example.com', '0987654321');

-- Insert sample data into BorrowingRecords table
INSERT INTO BorrowingRecords (MemberID, BookID, BorrowDate, ReturnDate, Status) VALUES
(1, 1, '2025-01-10', NULL, 'borrowed'),
(2, 2, '2025-02-01', '2025-02-20', 'returned');

-- Select some data to verify the database structure
SELECT * FROM Authors;
SELECT * FROM Books;
SELECT * FROM Members;
SELECT * FROM BorrowingRecords;
