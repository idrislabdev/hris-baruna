function createjsDOMenu() {
  staticMenu1 = new jsDOMenu(120, "static", "staticMenu", true);
  with (staticMenu1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "item2", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "item4", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "item5", "blank.htm"));
    show();
  }
  
  staticMenu1_1 = new jsDOMenu(130, "absolute");
  with (staticMenu1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "item2", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  staticMenu1_2 = new jsDOMenu(120, "absolute");
  with (staticMenu1_2) {
    addMenuItem(new menuItem("Item 1", "item1", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
  }
  
  staticMenu1_1_1 = new jsDOMenu(150, "absolute");
  with (staticMenu1_1_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 2", "item2", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "item3", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "", "blank.htm"));
  }
  
  staticMenu1_2_1 = new jsDOMenu(140, "absolute");
  with (staticMenu1_2_1) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("Item 4", "item4", "blank.htm"));
  }
  
  staticMenu1_2_2 = new jsDOMenu(150, "absolute");
  with (staticMenu1_2_2) {
    addMenuItem(new menuItem("Item 1", "", "blank.htm"));
    addMenuItem(new menuItem("Item 2", "item2", "blank.htm"));
    addMenuItem(new menuItem("Item 3", "", "blank.htm"));
    addMenuItem(new menuItem("-"));
    addMenuItem(new menuItem("Item 4", "", "blank.htm"));
    addMenuItem(new menuItem("Item 5", "item5", "blank.htm"));
  }
  
  staticMenu1.items.item2.setSubMenu(staticMenu1_1);
  staticMenu1.items.item5.setSubMenu(staticMenu1_2);
  staticMenu1_1.items.item3.setSubMenu(staticMenu1_1_1);
  staticMenu1_2.items.item1.setSubMenu(staticMenu1_2_1);
  staticMenu1_2.items.item3.setSubMenu(staticMenu1_2_2);
  
  staticMenu1.items.item2.showIcon("icon1", "icon2");
  staticMenu1.items.item4.showIcon("icon2", "icon3");
  staticMenu1_1.items.item2.showIcon("icon3", "icon1");
  staticMenu1_1.items.item3.showIcon("icon2", "icon3");
  staticMenu1_2.items.item1.showIcon("icon1", "icon2");
  staticMenu1_2.items.item3.showIcon("icon3", "icon1");
  staticMenu1_1_1.items.item2.showIcon("icon2", "icon3");
  staticMenu1_1_1.items.item3.showIcon("icon1", "icon3");
  staticMenu1_2_1.items.item4.showIcon("icon3", "icon1");
  staticMenu1_2_2.items.item2.showIcon("icon1", "icon2");
  staticMenu1_2_2.items.item5.showIcon("icon2", "icon3");
}