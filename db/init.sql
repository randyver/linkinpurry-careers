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


CREATE TABLE "User" (
    user_id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role user_role NOT NULL,
    nama VARCHAR(255) NOT NULL
);

CREATE TABLE "CompanyDetail" (
    user_id INT PRIMARY KEY,
    lokasi VARCHAR(255),
    about TEXT,
    FOREIGN KEY (user_id) REFERENCES "User"(user_id)
);

CREATE TABLE "Lowongan" (
    lowongan_id SERIAL PRIMARY KEY,
    company_id INT NOT NULL,
    posisi VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    jenis_pekerjaan VARCHAR(100) NOT NULL,
    jenis_lokasi VARCHAR(100) NOT NULL,
    is_open BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES "User"(user_id)
);

CREATE TABLE "AttachmentLowongan" (
    attachment_id SERIAL PRIMARY KEY,
    lowongan_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (lowongan_id) REFERENCES "Lowongan"(lowongan_id)
);

CREATE TABLE "Lamaran" (
    lamaran_id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    lowongan_id INT NOT NULL,
    cv_path VARCHAR(255) NOT NULL,
    video_path VARCHAR(255),
    status lamaran_status DEFAULT 'waiting',
    status_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES "User"(user_id),
    FOREIGN KEY (lowongan_id) REFERENCES "Lowongan"(lowongan_id)
);