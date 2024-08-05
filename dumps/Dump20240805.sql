CREATE DATABASE  IF NOT EXISTS `oficina_ci` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `oficina_ci`;
-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: localhost    Database: oficina_ci
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Clientes`
--

DROP TABLE IF EXISTS `Clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `veiculo` varchar(25) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `contato` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Clientes`
--

LOCK TABLES `Clientes` WRITE;
/*!40000 ALTER TABLE `Clientes` DISABLE KEYS */;
INSERT INTO `Clientes` VALUES (1,'João Silva','Ford Ka','ABC-1234','555-1234'),(2,'Maria Oliveira','Chevrolet Onix','DEF-5678','555-5678'),(3,'Carlos Souza','Toyota Corolla','GHI-9012','555-9012'),(4,'Ana Costa','Volkswagen Gol','JKL-3456','555-3456'),(5,'Lucas Pereira','Honda Civic','MNO-7890','555-7890');
/*!40000 ALTER TABLE `Clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Materiais`
--

DROP TABLE IF EXISTS `Materiais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Materiais` (
  `id_material` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_compra` decimal(10,2) NOT NULL,
  `preco_venda` decimal(10,2) NOT NULL,
  `habilitado` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id_material`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Materiais`
--

LOCK TABLES `Materiais` WRITE;
/*!40000 ALTER TABLE `Materiais` DISABLE KEYS */;
INSERT INTO `Materiais` VALUES (1,'Óleo de Motor 5W30','Óleo lubrificante sintético para motor',28,20.00,35.00,0,'2024-08-05'),(2,'Filtro de Ar','Filtro de ar para veículos de passeio',5,15.00,25.00,1,'2024-08-05'),(3,'Pneu 195/65 R15','Pneu para veículos de passeio',21,150.00,220.00,1,'2024-08-05'),(4,'Bateria 60Ah','Bateria automotiva 60Ah',10,200.00,350.00,1,'2024-08-05'),(5,'Velas de Ignição','Conjunto de 4 velas de ignição',50,30.00,55.00,1,'2024-08-05');
/*!40000 ALTER TABLE `Materiais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OrdemServico`
--

DROP TABLE IF EXISTS `OrdemServico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `OrdemServico` (
  `id_ordem_servico` int(11) NOT NULL AUTO_INCREMENT,
  `total` decimal(10,2) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `cliente` int(11) DEFAULT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id_ordem_servico`),
  KEY `usuario` (`usuario`),
  KEY `cliente` (`cliente`),
  CONSTRAINT `OrdemServico_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `Usuarios` (`email`),
  CONSTRAINT `OrdemServico_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `Clientes` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrdemServico`
--

LOCK TABLES `OrdemServico` WRITE;
/*!40000 ALTER TABLE `OrdemServico` DISABLE KEYS */;
INSERT INTO `OrdemServico` VALUES (1,245.00,'admin@gmail.com',1,'2024-08-05'),(2,1000.00,'mecanico@gmail.com',4,'2024-08-05'),(3,150.00,'mecanico@gmail.com',2,'2024-08-06'),(4,400.00,'mecanico@gmail.com',1,'2024-08-07');
/*!40000 ALTER TABLE `OrdemServico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OrdemServicoMaterial`
--

DROP TABLE IF EXISTS `OrdemServicoMaterial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `OrdemServicoMaterial` (
  `id_ordem_servico` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_ordem_servico`,`id_material`),
  KEY `id_material` (`id_material`),
  CONSTRAINT `OrdemServicoMaterial_ibfk_1` FOREIGN KEY (`id_ordem_servico`) REFERENCES `OrdemServico` (`id_ordem_servico`),
  CONSTRAINT `OrdemServicoMaterial_ibfk_2` FOREIGN KEY (`id_material`) REFERENCES `Materiais` (`id_material`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrdemServicoMaterial`
--

LOCK TABLES `OrdemServicoMaterial` WRITE;
/*!40000 ALTER TABLE `OrdemServicoMaterial` DISABLE KEYS */;
INSERT INTO `OrdemServicoMaterial` VALUES (1,1,2,35.00,70.00),(1,2,1,25.00,25.00),(2,3,4,220.00,880.00),(3,2,4,25.00,100.00);
/*!40000 ALTER TABLE `OrdemServicoMaterial` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER AtualizaEstoqueAoInserirOrdemServicoMaterial
AFTER INSERT ON OrdemServicoMaterial
FOR EACH ROW
BEGIN
    UPDATE Materiais
    SET quantidade = quantidade - NEW.quantidade
    WHERE id_material = NEW.id_material;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER AtualizaEstoqueAoAtualizarOrdemServicoMaterial
AFTER UPDATE ON OrdemServicoMaterial
FOR EACH ROW
BEGIN
    -- Verifica se a quantidade foi aumentada ou reduzida
    IF NEW.quantidade > OLD.quantidade THEN
        -- Se a quantidade nova for maior, subtrai a diferença do estoque
        UPDATE Materiais
        SET quantidade = quantidade - (NEW.quantidade - OLD.quantidade)
        WHERE id_material = NEW.id_material;
    ELSEIF NEW.quantidade < OLD.quantidade THEN
        -- Se a quantidade nova for menor, adiciona a diferença ao estoque
        UPDATE Materiais
        SET quantidade = quantidade + (OLD.quantidade - NEW.quantidade)
        WHERE id_material = NEW.id_material;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER AtualizaEstoqueAoDeletarOrdemServicoMaterial
AFTER DELETE ON OrdemServicoMaterial
FOR EACH ROW
BEGIN
    -- Devolve a quantidade de materiais ao estoque
    UPDATE Materiais
    SET quantidade = quantidade + OLD.quantidade
    WHERE id_material = OLD.id_material;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `OrdemServicoServico`
--

DROP TABLE IF EXISTS `OrdemServicoServico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `OrdemServicoServico` (
  `id_ordem_servico` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  PRIMARY KEY (`id_ordem_servico`,`id_servico`),
  KEY `id_servico` (`id_servico`),
  CONSTRAINT `OrdemServicoServico_ibfk_1` FOREIGN KEY (`id_ordem_servico`) REFERENCES `OrdemServico` (`id_ordem_servico`),
  CONSTRAINT `OrdemServicoServico_ibfk_2` FOREIGN KEY (`id_servico`) REFERENCES `Servicos` (`id_servico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OrdemServicoServico`
--

LOCK TABLES `OrdemServicoServico` WRITE;
/*!40000 ALTER TABLE `OrdemServicoServico` DISABLE KEYS */;
INSERT INTO `OrdemServicoServico` VALUES (1,6),(2,2),(3,3),(4,4);
/*!40000 ALTER TABLE `OrdemServicoServico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Servicos`
--

DROP TABLE IF EXISTS `Servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Servicos` (
  `id_servico` int(11) NOT NULL AUTO_INCREMENT,
  `id_servico_info` int(11) DEFAULT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_servico`),
  KEY `id_servico_info` (`id_servico_info`),
  CONSTRAINT `Servicos_ibfk_1` FOREIGN KEY (`id_servico_info`) REFERENCES `ServicosInfo` (`id_servico_info`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Servicos`
--

LOCK TABLES `Servicos` WRITE;
/*!40000 ALTER TABLE `Servicos` DISABLE KEYS */;
INSERT INTO `Servicos` VALUES (2,2,'2024-08-05','2024-08-05',120.00),(3,4,'2024-08-05','2024-08-05',50.00),(4,5,'2024-08-05','2024-08-05',400.00),(6,1,'2024-08-04','2024-08-05',150.00);
/*!40000 ALTER TABLE `Servicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ServicosInfo`
--

DROP TABLE IF EXISTS `ServicosInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ServicosInfo` (
  `id_servico_info` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_servico_info`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ServicosInfo`
--

LOCK TABLES `ServicosInfo` WRITE;
/*!40000 ALTER TABLE `ServicosInfo` DISABLE KEYS */;
INSERT INTO `ServicosInfo` VALUES (1,'Troca de Óleo',150.00),(2,'Alinhamento e Balanceamento',120.00),(3,'Revisão de Freios',200.00),(4,'Troca de Filtro de Ar',50.00),(5,'Revisão Completa',400.00);
/*!40000 ALTER TABLE `ServicosInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios` (
  `email` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel_acesso` enum('vendedor','mecanico','almoxarifado','admin') NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` VALUES ('admin@gmail.com','Admin','$2y$10$/DKWg8LvTZp5s6AyBjcag.0ZW4KAPs/UHcIvAEhr5hb2mzPbX.uNO','admin'),('almoxarifado@gmail.com','Ana Costa','$2y$10$m2XfI87WB92B9y7jAfhSHe0gK8SJHSW52TrgmYSAyUx4OvsOxolBa','almoxarifado'),('email@email.com','petrus','$2y$10$XBrBhSQ8nj0Slob5/.DAtedZoze0N4MRxyo0CU/Pll26k0dKpVnbq','admin'),('mecanico@gmail.com','Carlos Santos','$2y$10$pPzlz8i7nyth/vDvWSVDFe/XMIqc2a4dGTXdubG.ATNygVzacC2z6','mecanico'),('vendedor@gmail.com','Maria Oliveira','$2y$10$SbRcPo1Tx2XR8g0Qe4xpoOu/f3zCtm6M9cGfLXPYc5Z0SbIpwnAe6','vendedor');
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `VendaMaterial`
--

DROP TABLE IF EXISTS `VendaMaterial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `VendaMaterial` (
  `id_venda` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_venda`,`id_material`),
  KEY `id_material` (`id_material`),
  CONSTRAINT `VendaMaterial_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `Vendas` (`id_venda`),
  CONSTRAINT `VendaMaterial_ibfk_2` FOREIGN KEY (`id_material`) REFERENCES `Materiais` (`id_material`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `VendaMaterial`
--

LOCK TABLES `VendaMaterial` WRITE;
/*!40000 ALTER TABLE `VendaMaterial` DISABLE KEYS */;
INSERT INTO `VendaMaterial` VALUES (3,3,50,220.00,11000.00),(4,4,10,350.00,3500.00),(4,5,25,55.00,1375.00),(5,2,20,25.00,500.00),(6,1,20,35.00,700.00),(6,3,25,220.00,5500.00);
/*!40000 ALTER TABLE `VendaMaterial` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER AtualizaEstoqueAoInserirVenda
AFTER INSERT ON VendaMaterial
FOR EACH ROW
BEGIN
    UPDATE Materiais
    SET quantidade = quantidade - NEW.quantidade
    WHERE id_material = NEW.id_material;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER AtualizaEstoqueAoAtualizarVenda
AFTER UPDATE ON VendaMaterial
FOR EACH ROW
BEGIN
    -- Verifica se a quantidade foi aumentada ou reduzida
    IF NEW.quantidade > OLD.quantidade THEN
        -- Se a quantidade nova for maior, subtrai a diferença do estoque
        UPDATE Materiais
        SET quantidade = quantidade - (NEW.quantidade - OLD.quantidade)
        WHERE id_material = NEW.id_material;
    ELSEIF NEW.quantidade < OLD.quantidade THEN
        -- Se a quantidade nova for menor, adiciona a diferença ao estoque
        UPDATE Materiais
        SET quantidade = quantidade + (OLD.quantidade - NEW.quantidade)
        WHERE id_material = NEW.id_material;
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER AtualizaEstoqueAoDeletarVenda
AFTER DELETE ON VendaMaterial
FOR EACH ROW
BEGIN
    -- Devolve a quantidade de materiais ao estoque
    UPDATE Materiais
    SET quantidade = quantidade + OLD.quantidade
    WHERE id_material = OLD.id_material;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Vendas`
--

DROP TABLE IF EXISTS `Vendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Vendas` (
  `id_venda` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_venda`),
  KEY `usuario` (`usuario`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `Vendas_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `Usuarios` (`email`),
  CONSTRAINT `Vendas_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `Clientes` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vendas`
--

LOCK TABLES `Vendas` WRITE;
/*!40000 ALTER TABLE `Vendas` DISABLE KEYS */;
INSERT INTO `Vendas` VALUES (3,'2024-08-04 14:28:10','vendedor@gmail.com',11000.00,3),(4,'2024-08-05 14:29:14','vendedor@gmail.com',4875.00,4),(5,'2024-08-06 14:29:36','vendedor@gmail.com',500.00,2),(6,'2024-08-07 14:30:30','vendedor@gmail.com',6200.00,5);
/*!40000 ALTER TABLE `Vendas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-05 17:21:33
