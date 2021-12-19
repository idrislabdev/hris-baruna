function createjsDOMenu() {
absoluteMenu1 = new jsDOMenu(150, "static", "staticMenu", true);
  with (absoluteMenu1) {
    addMenuItem(new menuItem("Dynamic Drive", "", "http://www.dynamicdrive.com"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("JavaScript Kit", "", "http://www.javascriptkit.com"));
    addMenuItem(new menuItem("Coding Forums", "", "http://www.codingforums.com"));
    addMenuItem(new menuItem("FreewareJava", "", "http://www.freewarejava.com"));
    addMenuItem(new menuItem("Search Engines", "se", ""));
		moveTo(10, 280);
    show();
  }
  
  absoluteMenu1_1 = new jsDOMenu(130, "absolute");
  with (absoluteMenu1_1) {
    addMenuItem(new menuItem("Google", "", "http://www.google.com"));
    addMenuItem(new menuItem("Yahoo", "item2", "http://www.yahoo.com"));
    addMenuItem(new menuItem("MSN", "", "http://www.msn.com"));
    addMenuItem(new menuItem("Teoma", "item4", "http://www.teoma.com"));
    addMenuItem(new menuItem("Ask Jeeves", "", "http://www.askjeeves.com"));
  }
  
  absoluteMenu1.items.se.setSubMenu(absoluteMenu1_1);

}