    //filtration for document
     $('.intituleDocument, .typeDocument').keyup(function(){
        $('.container__pagination').hide();
        var intituleDocument = $(".intituleDocument").val();
        var typeDocument = $(".typeDocument").val();
        console.log(intituleDocument.length)
        if(intituleDocument.length > 0 && typeDocument.length == 0) {
            axios.post('/filtrationDocument?intituleDocument='+intituleDocument)
            .then((res) => {
                console.log(res.data)
                $(".TbodyDocument").empty();
                $(".TbodyDocument").html(res.data);
            })
            .catch((err) => {
                console.log(err)
            })
        }
        else if (intituleDocument.length == 0 && typeDocument.length > 0) {
            axios.post('/filtrationDocument?typeDocument='+typeDocument)
            .then((res) => {
                console.log(res.data)
                $(".TbodyDocument").empty();
                $(".TbodyDocument").html(res.data);
            })
            .catch((err) => {
                console.log(err)
            })
        }
        else if (intituleDocument.length == 0 && typeDocument.length == 0) {
            console.log('go back the first page')
            getDocument(0, 1) 
            $('.container__pagination').show();
        }
        else {
            axios.post('/filtrationDocument?typeDocument='+typeDocument+'&intituleDocument='+intituleDocument)
            .then((res) => {
                console.log(res.data)
                $(".TbodyDocument").empty();
                $(".TbodyDocument").html(res.data);
            })
            .catch((err) => {
                console.log(err)
            })
        }
     })
//end filtration for document
//filtration for action
     $('.intituleAction, .typeAction').keyup(function(){
        $('.container__pagination').hide();
        var intituleAction = $(".intituleAction").val();
        var typeAction = $(".typeAction").val();
        console.log(intituleAction.length)
        if(intituleAction.length > 0 && typeAction.length == 0) {
            axios.post('/filtrationAction?intituleAction='+intituleAction)
            .then((res) => {
                console.log(res.data)
                $(".TbodyAction").empty();
                $(".TbodyAction").html(res.data);
            })
            .catch((err) => {
                console.log(err)
            })
        }
        else if (intituleAction.length == 0 && typeAction.length > 0) {
            axios.post('/filtrationAction?typeAction='+typeAction)
            .then((res) => {
                console.log(res.data)
                $(".TbodyAction").empty();
                $(".TbodyAction").html(res.data);
            })
            .catch((err) => {
                console.log(err)
            })
        }
        else if (intituleAction.length == 0 && typeAction.length == 0) {
            console.log('go back the first page')
            getAction(0, 1) 
            $('.container__pagination').show();
        }
        else {
            axios.post('/filtrationAction?typeAction='+typeAction+'&intituleAction='+intituleAction)
            .then((res) => {
                console.log(res.data)
                $(".TbodyAction").empty();
                $(".TbodyAction").html(res.data);
            })
            .catch((err) => {
                console.log(err)
            })
        }
     })
 //end filtration for action