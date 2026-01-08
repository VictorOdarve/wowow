-- Alter tbl_nurses table to match the required fields
ALTER TABLE tbl_nurses DROP COLUMN assigned_department;
ALTER TABLE tbl_nurses DROP COLUMN work_schedule;
ALTER TABLE tbl_nurses ADD COLUMN available_days VARCHAR(255) NOT NULL;
ALTER TABLE tbl_nurses ADD COLUMN available_time_start TIME NOT NULL;
ALTER TABLE tbl_nurses ADD COLUMN available_time_end TIME NOT NULL;
