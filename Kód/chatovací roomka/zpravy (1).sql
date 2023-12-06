CREATE TABLE `zpravy` (
  `id` int(11) NOT NULL,
  `uzivatel_id` int(11) DEFAULT NULL,
  `obsah` text DEFAULT NULL,
  `cas` timestamp NOT NULL DEFAULT current_timestamp()
)

ALTER TABLE `zpravy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uzivatel_id` (`uzivatel_id`);

ALTER TABLE `zpravy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

ALTER TABLE `zpravy`
  ADD CONSTRAINT `zpravy_ibfk_1` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatel` (`id`);
COMMIT;
