YUI.add("yuidoc-meta", function(Y) {
   Y.YUIDoc = { meta: {
    "classes": [
        "RL.Note"
    ],
    "modules": [
        "RL.AudioManager",
        "RL.HighwayManager",
        "RL.InteractionManager",
        "RL.InteractionManager.Editor",
        "this"
    ],
    "allModules": [
        {
            "displayName": "RL.AudioManager",
            "name": "RL.AudioManager",
            "description": "This manages audio stuff.\nIt's to be used as a wrapper for any sound framework that might be used"
        },
        {
            "displayName": "RL.HighwayManager",
            "name": "RL.HighwayManager",
            "description": "The HighwayManager is responsible for drawing stuff on the canvas\nIt also contains methods for hit detection"
        },
        {
            "displayName": "RL.InteractionManager",
            "name": "RL.InteractionManager",
            "description": "Interaction manager for general rocklegend functions"
        },
        {
            "displayName": "RL.InteractionManager.Editor",
            "name": "RL.InteractionManager.Editor",
            "description": "Interaction manager for editor functions"
        },
        {
            "displayName": "this",
            "name": "this",
            "description": "This contains all needed functions\nfor the Rocklegend Track Editor"
        }
    ]
} };
});