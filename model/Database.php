<?php

class Database
{
	public static $_instance;

	private const HOST		= 'localhost';
	private const DBNAME	= '3wa-blog';
	private const USER		= 'root';
	private const PWD		= '';

	public function __construct()
	{
		//	Connexion à la base de données
		try 
		{

			if (self::$_instance === null) {
				self::$_instance = new PDO(
					'mysql:host='.self::HOST.';dbname='.self::DBNAME.';charset=UTF8',
					self::USER,
					self::PWD,
					[
						PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
					]
				);
				self::$_instance->exec('SET NAMES utf8mb4 COLLATE utf8mb4_general_ci');
				self::$_instance->query("SET lc_time_names = 'fr_FR';");
			}
		} 
		catch (PDOException $e) 
		{
			echo "Message d'erreur : $e->getMessage() /n Code erreur : $e->getCode()";
		}
	}
	
	/**
	 * Description Requête Insert/Update/Delete
	 * @param string $sql
	 * @param array $values
	 *
	 * @return int Le dernier id inseré en bdd sur cette table
	 */
	public function executeSql($sql, array $values = array())
	{
		try 
		{
			$query = self::$_instance->prepare($sql);
			$query->execute($values);
		} 
		catch (PDOException $e) 
		{
			echo "Message d'erreur : $e->getMessage <br />";
		}

		return self::$_instance->lastInsertId();
	}

	/**
	 * Description Requête Select pour récupérer un ensemble de résultats
	 * @param string $sql
	 * @param array $criteria
	 *
	 * @return array Ensemble de résultats
	 */
	public function findAll($sql, array $criteria = array())
	{
		try 
		{
			$query = self::$_instance->prepare($sql);
			$query->execute($criteria);
		} 
		catch (PDOException $e) 
		{
			echo "Message d'erreur : $e->getMessage()";
		}

		return $query->fetchAll();
	}

	/**
	 * Descritption Requête Select pour récupérer un seul résultat
	 * @param string $sql
	 * @param array $criteria
	 *
	 * @return array Un élément
	 */
	public function findOne($sql, array $criteria = array())
	{
		try 
		{
			$query = self::$_instance->prepare($sql);
			$query->execute($criteria);
		} 
		catch (PDOException $e) 
		{
			echo "Message d'erreur : $e->getMessage()";
		}

		return $query->fetch();
	}
}