DO $$ BEGIN
    CREATE TYPE user_role AS ENUM ('jobseeker', 'company');
EXCEPTION
    WHEN duplicate_object THEN NULL;
END $$;

DO $$ BEGIN
    CREATE TYPE lamaran_status AS ENUM ('accepted', 'rejected', 'waiting');
EXCEPTION
    WHEN duplicate_object THEN NULL;
END $$;


CREATE TABLE Users (
    user_id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role user_role NOT NULL,
    nama VARCHAR(255) NOT NULL
);

CREATE TABLE CompanyDetail (
    user_id INT PRIMARY KEY,
    lokasi VARCHAR(255),
    about TEXT,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Lowongan (
    lowongan_id SERIAL PRIMARY KEY,
    company_id INT NOT NULL,
    posisi VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    jenis_pekerjaan VARCHAR(100) NOT NULL,
    jenis_lokasi VARCHAR(100) NOT NULL,
    is_open BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES Users(user_id)
);

CREATE TABLE AttachmentLowongan (
    attachment_id SERIAL PRIMARY KEY,
    lowongan_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (lowongan_id) REFERENCES Lowongan(lowongan_id)
);

CREATE TABLE Lamaran (
    lamaran_id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    lowongan_id INT NOT NULL,
    cv_path VARCHAR(255) NOT NULL,
    video_path VARCHAR(255),
    status lamaran_status DEFAULT 'waiting',
    status_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (lowongan_id) REFERENCES Lowongan(lowongan_id)
);

-- DUMMY DATA
INSERT INTO Users (email, password, role, nama) VALUES
('jobseeker1@example.com', 'password123', 'jobseeker', 'John Doe'),
('jobseeker2@example.com', 'password123', 'jobseeker', 'Jane Doe'),
('company1@example.com', 'password123', 'company', 'Tech Corp'),
('company2@example.com', 'password123', 'company', 'Finance Inc.');

INSERT INTO CompanyDetail (user_id, lokasi, about) VALUES
(3, 'Jakarta, Indonesia', 'We are a leading tech company specializing in software solutions.'),
(4, 'Bandung, Indonesia', 'A financial services company with a global presence.');

INSERT INTO Lowongan (company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi) VALUES
(3, 'Software Engineer', 'Develop and maintain web applications.', 'Full-time', 'On-site'),
(3, 'DevOps Engineer', 'Manage cloud infrastructure and CI/CD pipelines.', 'Full-time', 'Remote'),
(4, 'Financial Analyst', 'Analyze financial data and market trends.', 'Full-time', 'On-site'),
(4, 'Accountant', 'Manage financial accounts and tax filings.', 'Part-time', 'Hybrid');

INSERT INTO AttachmentLowongan (lowongan_id, file_path) VALUES
(1, '/attachments/lowongan_1/file1.pdf'),
(2, '/attachments/lowongan_2/file2.pdf'),
(3, '/attachments/lowongan_3/file3.pdf');

INSERT INTO Lamaran (user_id, lowongan_id, cv_path, video_path) VALUES
(1, 1, '/cv/jobseeker1_cv.pdf', NULL),
(1, 2, '/cv/jobseeker1_cv.pdf', '/videos/jobseeker1_video.mp4'),
(2, 3, '/cv/jobseeker2_cv.pdf', NULL),
(2, 4, '/cv/jobseeker2_cv.pdf', '/videos/jobseeker2_video.mp4');