<!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Справочник </title>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<script src="js/jquery-1.7.2.js" type="text/javascript"></script>
	<script src="js/app.js" type="text/javascript"></script>
	
</head>
<body>
<div class="wrapper">
	<div class="header">
        <h1>Справочник предприятий, принимающий оплату за товары и услуги гарантированными платежами</h1>
    </div>
    <div class="clear"></div>
    <div class="content_nav">
        <div class="nav">
            <div class="nav_region">
                <div>
                     <label>Область:</label> 
                </div>
                <select>
                    <option>&nbsp;</option>
                    <option value=" Вся Украина"> Вся Украина</option>
                    <option value=" Днепропетровская"> Днепропетровская</option>
                </select>
                <hr/>
                <div>
                    <label>Город:</label> 
                </div>
                <select>
                    <option >&nbsp;</option>
                    <option value=" Вся Украина"> Вся Украина</option>
                    <option value=" Днепропетровская"> Днепропетровская</option>
                </select>
            </div>
            
            <div class="nav_menu">
                <div>
                    <p><a>Общепит</a></p>
                    
                </div>
                <hr/>
                <div>
                    <p><a>Автотовары, автотехника</a></p>
                    
                </div>
                <hr/>
                <div>
                    <p><a>Бухгалтерские,аудиторские и дилерские услуги</a></p>
                    
                </div>
                <hr/>
                <div>
                    <p><a>Общепит</a></p>
                    
                </div>
            </div>
        </div>
         <div class="content">
            <div class="search">
                <form>
                    <input type="text" placeholder="Поиск"/>
                    <input type="submit" value="Поиск"/>
                </form>
            </div>
            <div class="content_data ">
                <div class="table_title">
                    <div>
                        <div>Название</div>
                        <div>Адрес</div>
                        <div>Вид деятельности</div>
                    </div>
                </div>
                <div class="table_content">
                    <div>
                        <div>ООО "Рога"  </div>
                        <div>   г. Днепропетровск, ул. Набережная Победы 50  </div>
                        <div> продажа запчастей</div>
                    </div>
                    <div>
                        <div><img src="SCxzX"/></div>
                        <div>
                            <p><span class="bold">ЗАО "Копыта"</span> </p>
                            <p><span>г. Днепропетровск, ул. Набережная Победы 50</span></p>
                            <p><span>ремонт орг. техники</span></p>
                            <p><span>Контактное лицо: </span><span class="bold">Иванов Иван Иванович</span></p>
                            <p><span>Телефон: </span><span class="bold">380663214567</span></p>
                        </div>
                    </div>
                </div>
                  <div class="table_content">
                    <div>
                        <div>ООО "Рога"  </div>
                        <div>   г. Днепропетровск, ул. Набережная Победы 50  </div>
                        <div> продажа запчастей</div>
                    </div>
                    <div>
                        <div><img src="SCxzX"/></div>
                        <div>
                            <p><span class="bold">ЗАО "Копыта"</span> </p>
                            <p><span>г. Днепропетровск, ул. Набережная Победы 50</span></p>
                            <p><span>ремонт орг. техники</span></p>
                            <p><span>Контактное лицо: </span><span class="bold">Иванов Иван Иванович</span></p>
                            <p><span>Телефон: </span><span class="bold">380663214567</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="counter ">
                <h3>Уважаемый клиент!</h3>
                <p>Данный справочник содержит информацию о предприятиях, которые готовы выступать получателями гарантированных платежей.</p>
                <p>В настоящее время зарегистрировано <span> </span>получателей.</p>
                <p>Для перехода к списку предприятий выберите регион или вид деятельности.</p>
            </div>
            <hr />
            <div class="num_page">
                <a>1</a> <a>2</a> <a>3</a> <a>4</a> <a>5</a>
            </div>
         </div>
    </div>
</div>
</body>
</html>