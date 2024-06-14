SELECT 
        l.title,l.description,l.price_per_night,l.nb_room,l.nb_bed,l.nb_bath,l.nb_traveler,l.is_active,l.type,m.image_path
        FROM logement AS l
        INNER JOIN media AS m ON m.logement_id = l.id