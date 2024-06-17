SELECT l.id as logement_id,e.label,e.id as equipement_id,le.id as logement_equipement_id from equipement as e INNER JOIN `logementEquipement` as le on e.id = le.equipement_id inner join logement as l 
where le.logement_id = l.id 

SELECT e.id, e.label, e.image_path FROM equipement as e
        INNER JOIN `logementEquipement`  as le ON e.id = le.equipement_id
        WHERE le.logement_id = :id

SELECT * from equipement WHERE id = :logement_id