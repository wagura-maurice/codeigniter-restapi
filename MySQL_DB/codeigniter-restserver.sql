/*
 Navicat Premium Data Transfer

 Source Server         : MySQL Server
 Source Server Type    : MySQL
 Source Server Version : 100125
 Source Host           : localhost:3306
 Source Schema         : codeigniter-restserver

 Target Server Type    : MySQL
 Target Server Version : 100125
 File Encoding         : 65001

 Date: 15/01/2018 10:16:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access
-- ----------------------------
DROP TABLE IF EXISTS `access`;
CREATE TABLE `access`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `all_access` tinyint(1) NOT NULL DEFAULT 0,
  `controller` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_created` datetime(0) NULL DEFAULT NULL,
  `date_modified` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `controller`(`controller`) USING BTREE,
  INDEX `key`(`key`) USING BTREE,
  CONSTRAINT `access_ibfk_1` FOREIGN KEY (`key`) REFERENCES `keys` (`key`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for keys
-- ----------------------------
DROP TABLE IF EXISTS `keys`;
CREATE TABLE `keys`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date_created` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `key`(`key`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `keys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for limits
-- ----------------------------
DROP TABLE IF EXISTS `limits`;
CREATE TABLE `limits`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uri`(`uri`) USING BTREE,
  INDEX `api_key`(`api_key`) USING BTREE,
  CONSTRAINT `limits_ibfk_1` FOREIGN KEY (`api_key`) REFERENCES `keys` (`key`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `method` enum('get','post','options','put','patch','delete') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `params` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float NULL DEFAULT NULL,
  `authorized` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `response_code` smallint(3) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `api_key`(`api_key`) USING BTREE,
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`api_key`) REFERENCES `keys` (`key`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `version` bigint(20) NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (20170706032825);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_ip_address` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `last_user_agent` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `status` enum('pending','active','inactive') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'pending',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 116 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
