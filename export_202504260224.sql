INSERT INTO hackathon_matchroom.migrations (migration,batch) VALUES
	 ('0001_01_01_000000_create_users_table',1),
	 ('0001_01_01_000001_create_cache_table',1),
	 ('0001_01_01_000002_create_jobs_table',1),
	 ('2025_04_22_204632_create_personal_access_tokens_table',1),
	 ('2025_04_23_083604_create_hotels_table',1),
	 ('2025_04_23_090703_create_rooms_table',1),
	 ('2025_04_23_092049_create_swipes_table',1),
	 ('2025_04_23_120511_create_room_images_table',1),
	 ('2025_04_23_130340_add_negotiation_fields_to_rooms_table',1),
	 ('2025_04_23_130500_create_negotiations_table',1);
INSERT INTO hackathon_matchroom.migrations (migration,batch) VALUES
	 ('2025_04_23_135740_create_favorites_table',1),
	 ('2025_04_23_144223_add_new_fields',1),
	 ('2025_04_23_195701_add_column_firstname_to_users',1),
	 ('2025_04_24_082157_add_hotel_access_key_to_users_table',1),
	 ('2025_04_24_100333_create_room_equipments_table',1),
	 ('2025_04_24_103535_drop_column_type_from_rooms',1),
	 ('2025_04_24_115641_create_search_filters_table',1),
	 ('2025_04_24_120405_add_photo_path_to_rooms',1),
	 ('2025_04_24_131115_add_bed_column_to_rooms',1),
	 ('2025_04_24_132351_add_expires_at_to_negotiations_table',1);
INSERT INTO hackathon_matchroom.migrations (migration,batch) VALUES
	 ('2025_04_24_145141_add_description_column_to_rooms',1),
	 ('2025_04_24_150844_alter_negotiations_make_proposed_price_nullable',1),
	 ('2025_04_24_153405_update_negotiations_add_pending_status',1),
	 ('2025_04_24_174042_rename_type_to_role_in_users_table',1),
	 ('2025_04_24_175510_update_role_enum_add_admin',1),
	 ('2025_04_25_065250_create_reservations_table',1),
	 ('2025_04_25_143859_update_searchpreset_nam_to_nullable',1),
	 ('2025_04_25_174856_add_new_fields_in_hotel',1),
	 ('2025_04_25_233207_update_negotiation_status_add_pending',1);
