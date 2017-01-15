jQuery(window).ready(function() {
	notifyMe();
	checkNotifications();
});

function notifyMe() {

       window.setInterval(function() {
          checkNotifications();
        }, 30000);

}

function checkNotifications(){
	
	jQuery.ajax({
	        cache: false,
	        url: jQuery('head link[rel="notification-watch"]').attr("href"),
	}).done(function(data) {
		
		if(data.count > 0){
	    		
			$.each(data.notificacoes, function(i, item) {
							    
				Push.create(item.titulo, {
				body: item.descricao,
				icon: item.imagem,
				timeout: 0,
				requireInteraction: true,
				tag: item.tag,
				data: item.data,
				onClick: function () {
				    window.focus();
				    this.close();
				    window.open(item.url);
				},
				
				});
			
			});
	
		}
	
	});
            
}
