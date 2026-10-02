USE praktikum_web; 
 
INSERT INTO program_studi (nama_prodi) VALUES 
    ('Teknik Industri'), 
    ('Kedokteran'); 
 
INSERT INTO mahasiswa 
    (nim, nama, email, usia, program_studi_id) 
VALUES 
    ('2401020041', 'Rismayanti', 
     'risma@example.com', 20, 1), 
    ('2401020042', 'Sasa Agustin', 
     'sasa@example.com', 19, 1), 
    ('2401020133', 'Spy Holder', 
     'holder@example.com', 21, 2), 
    ('2401020123', 'Rumah Donat', 
     'donat@example.com', 18, 2); 
 
UPDATE mahasiswa 
SET email = 'donat@example.com' 
WHERE nim = '2401020123'; 
 
DELETE FROM mahasiswa 
WHERE nim = '2401020042'; 
 
SELECT m.nim, m.nama, m.email, m.usia, 
       p.nama_prodi 
FROM mahasiswa AS m 
JOIN program_studi AS p 
    ON p.id = m.program_studi_id 
ORDER BY m.nim;