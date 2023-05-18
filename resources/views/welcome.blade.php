<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body{
            padding-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="h4">Post</h1>
              <span id="editmsg"></span>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id='tableBody'>

                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <form name="myform">
                    <div class="form-group mb-2">
                        <h5>Create-Post</h5>
                        <span id="successmsg"></span> <br>
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control">
                        <span id="titleError"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Description</label>
                        <textarea name="description" id="" class="form-control" rows="4"></textarea>
                        <span id="descError"></span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Post</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit post</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
       <form name="editform" id="editmodal">
        <div class="modal-body">
            <div class="form-group mb-2">
                <span id="successmsg"></span> <br>
                <label for="">Title</label>
                <input type="text" name="title" class="form-control" required>
                <span id="titleError"></span>
            </div>
            <div class="form-group mb-2">
                <label for="">Description</label>
                <textarea name="description" id="" class="form-control" required rows="4"></textarea>
                <span id="descError"></span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
       </form>
      </div>
    </div>
  </div>





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  {{-- axios link --}}

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script>
      var tableBody = document.getElementById('tableBody');
      var titlelist = document.getElementsByClassName('titlelist');
      var desclist = document.getElementsByClassName('desclist');
      var idlist = document.getElementsByClassName('idlist');
      var Btnlist = document.getElementsByClassName('Btnlist');
        // READ
     axios.get("/api/posts")
            .then(response => {
                response.data.forEach(item=> {
                    display(item);

                });
                // console.log(response.data);
            })
            .catch(error => console.log(error));
            // Create
            var Myform = document.forms['myform'];
            var titleInput =myform['title'];
            var descriptionInput =myform['description'];
            myform.onsubmit = function(e){
                e.preventDefault();
                axios.post("api/posts",{
                    title : titleInput.value,
                    description : descriptionInput.value,
                })
                .then(
                    response => {
                        var titleErr = document.getElementById("titleError");
                        var descErr = document.getElementById("descError");
                        if(response.data.msg =="Create Data Successfully"){
                        document.getElementById("successmsg").innerHTML = '<i class="text-info">'+response.data.msg+'</i>';
                        Myform.reset();
                        display(response.data.post);
                        titleErr.innerHTML = descErr.innerHTML = '';


                        }else{

                            if(titleInput.value ==''){
                                titleErr.innerHTML= '<i class="text-danger">'+response.data.msg.title+'</i>';
                            }else{
                                titleErr.innerHTML = '';
                            }
                            if(descriptionInput.value==''){
                                descErr.innerHTML= '<i class="text-danger">'+response.data.msg.description+'</i>';
                            }else{
                                descErr.innerHTML = '';
                            }
                        }
                    }
                )
                .catch(
                    error => console.log(error)
                );
                // console.log(descriptionInput);
            }
            // edit & update
            var editform = document.forms['editform'];
            var edittitle = editform['title'];
            var editdesc = editform['description'];
            var postIdUpdateTODel;
            var oldtitle;
            // edit
            function editBtn(postId){
                postIdUpdateTODel = postId;
                axios.get("api/posts/"+postId)
                    .then(response =>
                   { console.log(response.data.title, response.data.description)
                    edittitle.value = response.data.title;
                    editdesc.value = response.data.description;

                    oldtitle = response.data.title;
                }
                    )
                    .catch(err => console.log(error));
            }
            // Update
            editform.onsubmit= function(e){
                e.preventDefault();
                // console.log("work");
                axios.put('api/posts/'+postIdUpdateTODel,{
                    title : edittitle.value,
                    description: editdesc.value,
                })
                    .then(
                        response => {
                            console.log(response.data)
                            document.getElementById("editmsg").innerHTML ='<i class="text-success">'+response.data.msg+'</i>';

                            for(var i=0;i<titlelist.length;i++){
                                if(titlelist[i].innerHTML==oldtitle){
                                    titlelist[i].innerHTML=edittitle.value;
                                    desclist[i].innerHTML=editdesc.value;
                                }
                            }
                        }
                    )
                    .catch(error => console.log(error));
            }

// Delete
function deleteBtn(postId){
   if(confirm("Sure to Delete!")){
    axios.delete("api/posts/"+postId)
            .then(res=>
            {
                console.log(res.data.DeletedPost.title);
                document.getElementById("editmsg").innerHTML ='<i class="text-danger">'+res.data.msg+'</i>';
                for(var i=0; i<titlelist.length;i++){
                    if(titlelist[i].innerHTML == res.data.DeletedPost.title){
                        idlist[i].style.display = 'none';
                        titlelist[i].style.display = 'none';
                        desclist[i].style.display = 'none';
                        Btnlist[i].style.display = 'none';
                    }
                }



            })
            .catch(err=>err);
   }
}
// Helper
function display(data){
    tableBody.innerHTML +=
                  ' <tr>'+
                    '<td class="idlist">'+data.id+'</td>'+
                    '<td class="titlelist">'+data.title+'</td>'+
                    '<td class="desclist">'+data.description+'</td>'+
                    '<td class="Btnlist"> <button class="btn btn-sm btn-success"  data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="editBtn('+data.id+')">edit</button>' +
                        ' <button class="btn btn-sm btn-danger" onclick=deleteBtn('+data.id+') >Del</button> </td>'+
                ' </tr>';
}

    </script>
</body>
</html>
