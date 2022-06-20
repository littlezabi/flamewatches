// sec_id zoombie
window.addEventListener("load", (event) => {
  onlineStatus = navigator.onLine;
});

window.addEventListener("offline", (event) => {
  onlineStatus = 0;
});

window.addEventListener("online", (event) => {
  onlineStatus = 1;
});
const setFrame = (video, setWatch = 1) => {
  if (prevVideo != null && setWatch !== 0) {
    setVideoWatch(prevVideo);
  }
  prevVideo = video;
  mainFrame.innerHTML = `<iframe id="vid-frame" width="420" height="315" src='https://www.youtube.com/embed/${video}?autoplay=${autoplay}&mute=1&controls=${controlsOfVideo}&rel=${relatedVideos}&modestbranding=${modestbranding}&loop=${loopVideo}'> </iframe>`;
};
setInterval(() => {
  if (onlineStatus) {
    statusDisplay.classList.add("active");
    statusDisplay.style.background = "#03a9f4";
  } else {
    statusDisplay.style.background = "#ff5d51";
  }
}, 3000);
setInterval(() => {
  statusDisplay.classList.remove("active");
}, 2000);
isPlaying = autoplay;
let vidList = [];
const setVidList = (data) => {
  vidList = [];
  if (StartStream) {
    data.map((e) => {
      vidList.push(e.url);
    });
  }
};
setVidList(RawVidList);
if (userLogged === 1 || userLogged === "1") setFrame(vidList[0]);
else setFrame([""]);

// sec_id grand1
if (userLogged === 1 || userLogged === "1") {
  setTimeout(() => {
    setInterval(() => {
      window.focus();

      if (onlineStatus && isPlaying) {
        callTimer();
      } else {
        // alert("Goes offline :( when connection is ready hit enter to try again!");
      }
    }, 1000);
  }, 5000);
}
const setLoader = (time, maxTime) => {
  width = Math.floor((time / maxTime) * 100);
  loader.style.width = `${width}%`;
};
const callTimer = () => {
  timer = timer - 1;
  totalWatch += 1;
  seconds.innerHTML = timer;
  if (timer <= 0) {
    setPoints(pointsMultiplier * watchCounter);
    // setPoints(watchCounter * Increment);
    watchCounter += 1;
    timer = watchCounter * Increment;
  }
  if (totalWatch >= watchTime) {
    videoWatch += 1;
    totalWatch = 0;
    videoWatch = setSource(videoWatch);
  }
  setLoader(timer, watchCounter * Increment);
};
const playNext = () => {
  index = vidList.length - 1;
  watch = Math.ceil(Math.random() * index);
  isPlaying = 0;
  setFrame(vidList[watch], (setWatch = 0));
};
setSource = (watch) => {
  watch = watch - 1;
  index = vidList.length - 1;
  
  let return_watch = 0;
  if (watch >= index) {
    setVidList(getVidList());
    watch = Math.ceil(Math.random() * index);
    return_watch = 0;
  }
  setFrame(vidList[watch]);

  return_watch = watch;
  return return_watch;
};

const showModal = (type) => {
  if (type === "add-new-vid") {
    coinsView.innerHTML = CurrentPoints.textContent;
    watchInput.value = 10;
    document.querySelector(".modal").style.display = "flex";
  }
};

window.addEventListener("load", (event) => {
  try {
    const profileImg = document.querySelector("#profile-img");
    let isLoaded = profileImg.complete && profileImg.naturalHeight !== 0;
    if (!isLoaded) {
      let newChild = document.createElement("i");
      newChild.classList.add("fa");
      newChild.classList.add("fa-user");
      newChild.style.zIndex = "1";
      profileImg.parentNode.replaceChild(newChild, profileImg);
    }
  } catch (error) {}
});

window.addEventListener("blur", () => {
  setTimeout(() => {
    if (document.activeElement.tagName === "IFRAME") {
      // if (isPlaying) {
      //   document.querySelector(".overlay-subs").style.display = "block";
      //   document.querySelector(".overlay-vid").style.display = "block";
      // } else {
      //   document.querySelector(".overlay-subs").style.display = "none";
      //   document.querySelector(".overlay-vid").style.display = "none";
      // }
      isPlaying = !isPlaying;
    }
  });
});

watchInput.addEventListener("keyup", (e) => {
  let value = watchInput.value.replace(/\D/g, "");
  if (typeof watchInput.value !== "number") {
    if (value < 10) {
      watchInput.value = 10;
      return 1;
    }
    if (value * perWatchPoints > CurrentPoints.textContent) {
      message.innerHTML = "Your points is not engough for increasing watches!";
      message.classList.add("alert");
    } else {
      watchInput.value = value;
      counterMultiplierSpan.innerHTML = value;
      counterCoins.innerHTML = value * perWatchPoints;
      coinsView.innerHTML = CurrentPoints.textContent;
    }
  }
});
const setWatchCounter = (action) => {
  let prev = watchInput.value;

  const message = document.querySelector("#message");
  message.classList.remove("alert");
  let newValue = 10;
  if (action) {
    newValue = ++prev;
  } else {
    if (prev >= 11) {
      newValue = --prev;
    }
  }
  if (newValue * perWatchPoints > CurrentPoints.textContent) {
    message.innerHTML = "Your points is not engough for increasing watches!";
    message.classList.add("alert");
  } else {
    watchInput.value = newValue;
    counterMultiplierSpan.innerHTML = newValue;
    counterCoins.innerHTML = newValue * perWatchPoints;
  }
  coinsView.innerHTML = CurrentPoints.textContent;
};

setInterval(()=>checkLoginStatus(), 10000);

