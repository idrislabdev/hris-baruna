function createjsDOMenu() {
  fixedMenu1 = new jsDOMenu(120, "fixed", "", true);
  with (fixedMenu1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 5", "item5", "blank.htm"));
    moveTo(10, 150);
    show();
  }
  
  fixedMenu1_1 = new jsDOMenu(130, "fixed");
  with (fixedMenu1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "item2", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  fixedMenu1_2 = new jsDOMenu(120, "fixed");
  with (fixedMenu1_2) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "item4", "blank.htm"));
  }
  
  fixedMenu1_1_1 = new jsDOMenu(150, "fixed");
  with (fixedMenu1_1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
  }
  
  fixedMenu1_2_1 = new jsDOMenu(140, "fixed");
  with (fixedMenu1_2_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  fixedMenu1_2_2 = new jsDOMenu(150, "fixed");
  with (fixedMenu1_2_2) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
  }
  
  fixedMenu1.items.item3.setSubMenu(fixedMenu1_1);
  fixedMenu1.items.item5.setSubMenu(fixedMenu1_2);
  fixedMenu1_1.items.item2.setSubMenu(fixedMenu1_1_1);
  fixedMenu1_2.items.item3.setSubMenu(fixedMenu1_2_1);
  fixedMenu1_2.items.item4.setSubMenu(fixedMenu1_2_2);
  
  absoluteMenu1 = new jsDOMenu(120, "absolute", "", true);
  with (absoluteMenu1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "item2", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "item5", "blank.htm"));
    moveTo(10, 440);
    show();
  }
  
  absoluteMenu1_1 = new jsDOMenu(130, "absolute");
  with (absoluteMenu1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  absoluteMenu1_2 = new jsDOMenu(120, "absolute");
  with (absoluteMenu1_2) {
    addMenuItem(new menuItem("Item 1", "item1", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  absoluteMenu1_1_1 = new jsDOMenu(150, "absolute");
  with (absoluteMenu1_1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
  }
  
  absoluteMenu1_2_1 = new jsDOMenu(140, "absolute");
  with (absoluteMenu1_2_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  absoluteMenu1_2_2 = new jsDOMenu(150, "absolute");
  with (absoluteMenu1_2_2) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
  }
  
  absoluteMenu1.items.item2.setSubMenu(absoluteMenu1_1);
  absoluteMenu1.items.item5.setSubMenu(absoluteMenu1_2);
  absoluteMenu1_1.items.item3.setSubMenu(absoluteMenu1_1_1);
  absoluteMenu1_2.items.item1.setSubMenu(absoluteMenu1_2_1);
  absoluteMenu1_2.items.item3.setSubMenu(absoluteMenu1_2_2);
  
  cursorMenu1 = new jsDOMenu(150);
  with (cursorMenu1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  cursorMenu1_1 = new jsDOMenu(130);
  with (cursorMenu1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "item2", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "item4", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
  }
  
  cursorMenu1_1_1 = new jsDOMenu(160);
  with (cursorMenu1_1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  cursorMenu1_1_2 = new jsDOMenu(140);
  with (cursorMenu1_1_2) {
    addMenuItem(new menuItem("Item 1", "item1", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
  }
  
  cursorMenu1_1_2_1 = new jsDOMenu(120);
  with (cursorMenu1_1_2_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "item5", "blank.htm"));
  }
  
  cursorMenu1_1_2_1_1 = new jsDOMenu(130);
  with (cursorMenu1_1_2_1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  cursorMenu1.items.item3.setSubMenu(cursorMenu1_1);
  cursorMenu1_1.items.item2.setSubMenu(cursorMenu1_1_1);
  cursorMenu1_1.items.item4.setSubMenu(cursorMenu1_1_2);
  cursorMenu1_1_2.items.item1.setSubMenu(cursorMenu1_1_2_1);
  cursorMenu1_1_2_1.items.item5.setSubMenu(cursorMenu1_1_2_1_1);
  
  setPopUpMenu(cursorMenu1);
  activatePopUpMenuBy(0, 2);
}