function handleDelete(id, element) {
  const confirm_ = confirm("Do you want to Delete video");
  if (confirm_) {
    axios
      .get(ROOT_URL + `/functions/action.php?delVideo=1&video=${id}`)
      .then((response) => {
        if (response.data === "success") {
          console.log(response.data);
          let k = window.confirm("Enter ok to reload the page.");
          if (k) {
            window.location.href = "/";
          }
        }
      })
      .catch((err) => {
        console.log(err);
      });
  }
}
function handleStatus(id, status, element) {
  axios
    .get(
      ROOT_URL + `/functions/action.php?vidStatus=1&id=${id}&status=${status}`
    )
    .then((response) => {
      if (response.data === "success") {
        element.innerHTML = "<small>Reload required</small>";
        window.alert(
          "Reload now! to take effect or reload later to change the layout."
        );
      }
    })
    .catch((err) => {
      console.log(err);
    });
}
function setVideoWatch(video) {
  axios
    .get(ROOT_URL + `/functions/action.php?setVideoWatch=1&video=${video}`)
    .then((response) => {})
    .catch((err) => {
      console.log(err);
    });
}
function buttonAction(element, type, state) {
  state = !state;
  axios
    .get(
      ROOT_URL + `/functions/action.php?setConfig=1&type=${type}&state=${state}`
    )
    .then((response) => {
      if (response.data == "success") {
        window.location.href = "/";
      }
    })
    .catch((err) => {
      console.log(err);
    });
}

const addVideo = async () => {
  const url = document.querySelector("#vid-link");
  const message = document.querySelector("#message");
  message.innerHTML = "";
  message.classList.remove("success");
  message.classList.remove("alert");
  message.classList.remove("error");
  if (url.value == "") {
    message.classList.add("alert");
    message.innerHTML = "Please enter a video url.";
    return 1;
  }

  let link = url.value;
  if (link.split("watch").length > 1) {
    link = link.split("=")[1].split("&")[0];
  } else if (link.split("embed").length > 1) {
    link = link.split("embed")[1].split("/")[1].split("?")[0];
  } else if (link.split("youtu.be").length > 1) {
    link = link.split("youtu.be")[1].split("/")[1].split("?")[0];
  } else if (link.split("shorts").length > 1) {
    link = link.split("shorts")[1].split("/")[1].split("?")[0];
  }
  link = btoa(link);
  let full_link = btoa(url.value);
  let watches = btoa(watchInput.value);
  await axios
    .get(
      ROOT_URL +
        "/functions/action.php?addVid=1&url=" +
        link +
        "&full_url=" +
        full_link +
        "&watches=" +
        watches
    )
    .then((res) => {
      if (response === "urlAlreadyExist") {
        message.innerHTML =
          "Your entered video url is already exist please choose another one!";
        message.classList.add("alert");
      }
      if (response === "lessPoints") {
        message.innerHTML =
          "your points is not enough for uploading this video watch videos and earn points or buy points!";
        message.classList.add("alert");
      }
      if (response === "tasksReached") {
        message.innerHTML =
          "Your Tasks is reached! delete some videos and upload new video!";
        message.classList.add("alert");
      }
      if (response === "success") {
        message.innerHTML = "URL add successfully!";
        message.classList.add("success");
        setPoints((pointsMultiplier = 0));
        window.location.href = "/";
        message.innerHTML = "";
        message.classList.remove("success");
        message.classList.remove("alert");
        message.classList.remove("error");
      }
      if (response === "UserNotLogged") {
        message.innerHTML =
          "User is not logged please <a href='/login.php'>login</a> and try again";
        message.classList.add("alert");
      }
    })
    .catch((err) => console.log(err));
  url.value = "";
};

const getVidList = async (limit = 2) => {
  await axios
    .get(ROOT_URL + "/functions/action.php?vidList=1")
    .then((req) => {
      console.log("rewq: ", req.data);
      if (req.data.length > 0) return req.data;
      else return [];
    })
    .catch((err) => console.log(err));
  return [];
};
const setPoints = async (pointsMultiplier = 0) => {
  if (pointsMultiplier != 0) {
    if (autoplay == 1 || autoplay == "1" || autoplay == true) {
      pointsMultiplier = (pointsMultiplier * DeductAutoPlayPoints) / 100;
    }
    await axios
      .post(ROOT_URL + "/functions/action.php", {
        setPoints: 1,
        points: pointsMultiplier,
      })
      .then((response) => {
        if (response.data != "userNotLogged") {
          points.innerHTML = response.data;
        } else {
          inlineMsg.innerHTML = "User not logged";
        }
      })
      .catch((er) => console.log(er));
  }
  await axios
    .get(ROOT_URL + "/functions/action.php?updatePoints=1")
    .then((response) => {
      if (response.data != "userNotLogged") {
        points.innerHTML = response.data;
      } else {
        inlineMsg.innerHTML = "User not logged";
      }
    })
    .catch((er) => console.log(er));
};

const checkLoginStatus = () => {
  let response = ''
  axios
    .get(ROOT_URL + "/functions/action.php?checkLoginStatus=1")
    .then((response) => {
      
      if (response.data === "userNotLogged") {
        window.location.href = "/login.php";
      }
    })
    .catch((er) => console.error(er));
};
