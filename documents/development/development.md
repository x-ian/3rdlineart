## Runtime stuff

### Environment & software versions

* Ubuntu 16.04.1 LTS
* MySQL 5.7.22
* Apache 2.4.18
* PHP 7.0.30

### Development & Deployment

### G4S and phone number for lab samples

ALTER TABLE `3rdlineart9_db`.`sample` 
ADD COLUMN `phone` VARCHAR(30) NULL AFTER `date_created`,
ADD COLUMN `g4s_notification` VARCHAR(30) NULL AFTER `phone`;

### Asynchronously sending email from table email_log

The web app adds mails-to-be-sent into the table email_log. A cronjob will invoke 3rdlineart/send_emails.php every 10 minutes.

*/10 * * * * cd /var/www/html/3rdlineart && /usr/bin/php send_emails.php

### DB schema

* Constraints between all foreign keys
* cascading deletes within related tables (form/application, patient, users/roles), but not across these blocks

### Mcrypt

Mcrypt is deprecated / non-functioning on newer PHP versions. PHP 7.0 appears to be the latest out of the box version with support for Mcrypt. Any update in a production environment needs to somehow handle (or even migrate away) from mcrypt.

Under Mac OS 10.14 Mojave the default PHP installation can't handle mcrypt. Compiling from old sources bypasses this:
* https://donatstudios.com/Install-PHP-Mcrypt-Extension-in-OS-X
* https://donatstudios.com/Disable-macOS-System-Integrity-Protection

### Reseting database records

-- delete all patients and forms
DELETE FROM form_creation;
DELETE FROM patient;

-- reset runtime/data tables
DELETE FROM email_log;
DELETE FROM login_attempts;

-- reset config tables
DELETE FROM users;
DELETE FROM drugs;
DELETE FROM facility;
DELETE FROM facilitys;
DELETE FROM partner_org;

## Upgrading

### Fixing existing and adding new art_drugs

update drugs set date_created = '22/07/2018' where id =3;
update drugs set description = 'TRX' where id =13;

-- missing from new guidelines
INSERT INTO drugs
(`drug_name`, `line`, `description`, `date_created`)
VALUES
('ABC-3TC', 2, 'ABC-3TC', '22/04/2019'),
('AZT-3TC', 2, 'AZT-3TC', '22/04/2019'),
('r', 2, 'r', '22/04/2019'),
('TDF-3TC', 2, 'TDF-3TC', '22/04/2019');

-- old entries from treatment history missing in drugs
INSERT INTO drugs
(`drug_name`, `line`, `description`, `date_created`)
VALUES
('ABC-3TC-EFV', 2, 'ABC-3TC-EFV', '22/04/2019'),
('D4T-3TC-NVP', 2, 'D4T-3TC-NVP', '22/04/2019'),
('D4T-3TC-EFV', 2, 'D4T-3TC-EFV', '22/04/2019'),
('ABC-3TC-ATV/r', 2, 'ABC-3TC-ATV/r', '22/04/2019');

-- adding constraints between treatment_history and art_drug
update treatment_history set art_drug='TDF-3TC-ATV/r' where art_drug='ATV/r-3TC-TDF';
update treatment_history set art_drug='ABC-NVP-3TC' where art_drug='ABC-3TC-NVP';


#### for reference

in current guidelines:

* ABC / 3TC
* ATV/r 
* AZT / 3TC
* AZT / 3TC / NVP 
* AZT/3TC
* DTG 
* EFV 
* LPV/r 
* NVP 
* r 
* TDF / 3TC
* TDF / 3TC / DTG 
* TDF / 3TC / EFV

### Remove all constraints

```
-- https://stackoverflow.com/questions/17072786/drop-all-table-constraints-in-mysql

   SELECT CASE constraint_type
       WHEN 'FOREIGN KEY'
        THEN concat('alter table ', table_schema, '.', table_name, ' DROP FOREIGN KEY ', constraint_name, ';')
       END
   FROM information_schema.table_constraints
   WHERE constraint_type IN ('FOREIGN KEY')
      AND table_schema = '3rdlineart9_db';
```

### Rebuild constraints & update schema

-- patient
ALTER TABLE adherence ADD CONSTRAINT adherence_fk_1 FOREIGN KEY (pat_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE adherence_questions ADD CONSTRAINT adherence_questions_fk_1 FOREIGN KEY (pat_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE art_interruption ADD CONSTRAINT art_interruption_fk_1 FOREIGN KEY (patient_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE current_clinical_status ADD CONSTRAINT current_clinical_status_fk_1 FOREIGN KEY (patient_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE current_clinical_status_details ADD CONSTRAINT current_clinical_status_details_fk_1 FOREIGN KEY (pat_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE lab ADD CONSTRAINT lab_fk_1 FOREIGN KEY (pat_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE monitoring ADD CONSTRAINT `monitoring_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE ol_6months_details ADD CONSTRAINT ol_6months_details_fk_1 FOREIGN KEY (patient_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE patient_side_effects ADD CONSTRAINT patient_side_effects_fk_1 FOREIGN KEY (patient_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pediatric ADD CONSTRAINT `pediatric_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pregnancy ADD CONSTRAINT `pregnancy_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE tb_treat ADD CONSTRAINT tb_treat_fk_1 FOREIGN KEY (pat_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE tb_treatment ADD CONSTRAINT `tb_treatment_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE tb_treat_mdr ADD CONSTRAINT tb_treat_mdr_fk_1 FOREIGN KEY (pat_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE tb_treat_regimen1 ADD CONSTRAINT tb_treat_regimen1_fk_1 FOREIGN KEY (pat_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE tb_treat_regimen2 ADD CONSTRAINT tb_treat_regimen2_fk_1 FOREIGN KEY (pat_id) REFERENCES patient(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE treatment_history ADD CONSTRAINT `treatment_history_ibfk_1` FOREIGN KEY (`pat_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- form
-- ALTER TABLE email_log ADD CONSTRAINT email_log_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`);
ALTER TABLE app_results ADD CONSTRAINT app_results_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE assigned_app_results ADD CONSTRAINT assigned_app_results_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE assigned_forms ADD CONSTRAINT assigned_forms_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE expert_review_consolidate1 ADD CONSTRAINT export_review_consolidate1_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE expert_review_consolidate2 ADD CONSTRAINT export_review_consolidate2_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE expert_review_form ADD CONSTRAINT expert_review_form_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE expert_review_result ADD CONSTRAINT expert_review_result_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE form_rejected ADD CONSTRAINT `form_rejected_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE lab_vl_repeat ADD CONSTRAINT lab_vl_repeat_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE reviewer_team_lead ADD CONSTRAINT reviewer_team_lead_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE reviewer_team_lead2 ADD CONSTRAINT reviewer_team_lead2_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE sample ADD CONSTRAINT sample_fk_1 FOREIGN KEY (`form_id`) REFERENCES `form_creation` (`3rdlineart_form_id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- user / role
ALTER TABLE clinician ADD  CONSTRAINT `clinician_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pih_lab ADD  CONSTRAINT `pih_lab_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE secretary ADD  CONSTRAINT `secretary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE reviewer ADD  CONSTRAINT `reviewer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `admin` ADD CONSTRAINT admin_fk_3 FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- patient & form to user / role
ALTER TABLE reviewer_team_lead ADD CONSTRAINT reviewer_team_lead_fk_2 FOREIGN KEY (`rev_id`) REFERENCES `reviewer` (`id`);
ALTER TABLE reviewer_team_lead2 ADD CONSTRAINT reviewer_team_lead2_fk_2 FOREIGN KEY (`rev_id`) REFERENCES `reviewer` (`id`);
ALTER TABLE expert_review_result ADD CONSTRAINT expert_review_result_fk_2 FOREIGN KEY (`rev_id`) REFERENCES `reviewer` (`id`);
delete from expert_review_form where id=16;
ALTER TABLE expert_review_form ADD CONSTRAINT expert_review_form_fk_2 FOREIGN KEY (`rev_id`) REFERENCES `reviewer` (`id`);
ALTER TABLE assigned_app_results ADD CONSTRAINT assigned_app_results_fk_2 FOREIGN KEY (`rev_id`) REFERENCES `reviewer` (`id`);
delete from assigned_forms where id = 31;
ALTER TABLE assigned_forms ADD CONSTRAINT assigned_forms_fk_2 FOREIGN KEY (`rev_id`) REFERENCES `reviewer` (`id`);
ALTER TABLE assigned_app_results ADD CONSTRAINT assigned_app_results_fk_3 FOREIGN KEY (`sec_id`) REFERENCES `secretary` (`id`);
update assigned_forms set sec_id=6 where id in (33,34,35);
ALTER TABLE assigned_forms ADD CONSTRAINT assigned_forms_fk_3 FOREIGN KEY (`sec_id`) REFERENCES `secretary` (`id`);
ALTER TABLE expert_review_consolidate2 ADD CONSTRAINT expert_review_consolidate2_fk_3 FOREIGN KEY (`sec_id`) REFERENCES `secretary` (`id`);
delete from reviewer_team_lead where id=15;
ALTER TABLE reviewer_team_lead ADD CONSTRAINT reviewer_team_lead_fk_3 FOREIGN KEY (`sec_id`) REFERENCES `secretary` (`id`);
ALTER TABLE reviewer_team_lead2 ADD CONSTRAINT reviewer_team_lead2_fk_3 FOREIGN KEY (`sec_id`) REFERENCES `secretary` (`id`);
ALTER TABLE lab_vl_repeat ADD CONSTRAINT lab_vl_repeat_fk_4 FOREIGN KEY (`lab_personel_id`) REFERENCES `pih_lab` (`id`);
ALTER TABLE `sample` ADD CONSTRAINT sample_fk_3 FOREIGN KEY (`clinician_id`) REFERENCES `clinician` (`id`);
ALTER TABLE form_creation ADD CONSTRAINT `form_creation_ibfk_1` FOREIGN KEY (`clinician_id`) REFERENCES `clinician` (`id`);
ALTER TABLE form_creation ADD CONSTRAINT `form_creation_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`);

-- misc
ALTER TABLE drugs ADD UNIQUE INDEX `index2` (`drug_name` ASC);
ALTER TABLE treatment_history ADD CONSTRAINT art_drug_fk_1 FOREIGN KEY (art_drug) REFERENCES drugs(drug_name);

ALTER TABLE clinician DROP COLUMN `linked`;
ALTER TABLE reviewer DROP COLUMN `linked`;
ALTER TABLE secretary DROP COLUMN `linked`;
ALTER TABLE secretary ADD COLUMN `isActive` INT(1) NULL DEFAULT '0' AFTER `email`;

