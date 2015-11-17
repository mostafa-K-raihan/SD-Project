ALTER TABLE `match`
ADD CONSTRAINT `team_id_match_1` FOREIGN KEY (`team1_id`) REFERENCES `team` (`team_id`),
ADD CONSTRAINT `team_id_match_2` FOREIGN KEY (`team2_id`) REFERENCES `team` (`team_id`),
ADD CONSTRAINT `tournament_id_match_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`tournament_id`);


ALTER TABLE `phase`
ADD CONSTRAINT `tournament_id_phase_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`tournament_id`);

ALTER TABLE `player`
ADD CONSTRAINT `team_id_player_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`);

ALTER TABLE `player_match_point`
ADD CONSTRAINT `player_id_pmp_1` FOREIGN KEY (`player_id`) REFERENCES `player` (`player_id`),
ADD CONSTRAINT `match_id_pmp_1` FOREIGN KEY (`match_id`) REFERENCES `match` (`match_id`);

ALTER TABLE `player_tournament`
ADD CONSTRAINT `player_id_pt_1` FOREIGN KEY (`player_id`) REFERENCES `player` (`player_id`),
ADD CONSTRAINT `tournament_id_pt_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`tournament_id`);

ALTER TABLE `team_tournament`
ADD CONSTRAINT `team_id_tt_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`team_id`),
ADD CONSTRAINT `tournament_id_tt_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`tournament_id`);

ALTER TABLE `user_match_team`
ADD CONSTRAINT `user_id_umt_1` FOREIGN KEY (`user_id`) REFERENCES `userinfo` (`user_id`),
ADD CONSTRAINT `match_id_umt_1` FOREIGN KEY (`match_id`) REFERENCES `match` (`match_id`),
ADD CONSTRAINT `captain_id_umt_1` FOREIGN KEY (`captain_id`) REFERENCES `player` (`player_id`);

ALTER TABLE `user_match_team_player`
ADD CONSTRAINT `user_match_team_id_umt_1` FOREIGN KEY (`user_match_team_id`) REFERENCES `user_match_team` (`user_match_team_id`),
ADD CONSTRAINT `player_id_umt_1` FOREIGN KEY (`player_id`) REFERENCES `player` (`player_id`);

ALTER TABLE `user_phase_transfer`
ADD CONSTRAINT `user_id_upt_1` FOREIGN KEY (`user_id`) REFERENCES `userinfo` (`user_id`),
ADD CONSTRAINT `phase_id_upt_1` FOREIGN KEY (`phase_id`) REFERENCES `phase` (`phase_id`);

ALTER TABLE `user_tournament`
ADD CONSTRAINT `user_id_ut_1` FOREIGN KEY (`user_id`) REFERENCES `userinfo` (`user_id`),
ADD CONSTRAINT `tournament_id_ut_1` FOREIGN KEY (`tournament_id`) REFERENCES `tournament` (`tournament_id`);