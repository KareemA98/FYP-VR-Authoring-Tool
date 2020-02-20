using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public static class StaticVariableScript {
	private static int levelNumber;
	private static int nextLevel;

	public static int LevelNumber {
		get {
			return levelNumber;
		}
		set {
			levelNumber = value;
		}
	}
	public static int NextLevel {
		get{
			return nextLevel;
		}
		set{
			nextLevel = value;
		}
	}
}
