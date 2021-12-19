function createjsDOMenu() {
  cursorMenu1 = new jsDOMenu(120);
  with (cursorMenu1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
    setNoneExceptFilter(new Array("DIV.showupregion"));
  }
  setPopUpMenu(cursorMenu1);
  activatePopUpMenuBy(0, 0);
}