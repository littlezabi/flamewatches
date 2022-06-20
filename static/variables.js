// sec_id zoombie
const vidFrame = document.getElementById("vid-frame");
const seconds = document.querySelector(".seconds");
const points = document.querySelector("#points");
const mainFrame = document.querySelector("#mainframe");
const loader = document.querySelector(".loading-bar .load-cont .filler");
const inlineMsg = document.querySelector(".inlineMsg");
const watchInput = document.querySelector(".watch-counter input");
const counterMultiplierSpan = document.querySelector(
  ".counter-multiplier span.counter"
);
const coinsView = document.querySelector("#coins-view");
const CurrentPoints = document.querySelector(".last-ul #points");
const counterCoins = document.querySelector(".counter-multiplier .coins");
let statusDisplay = document.querySelector(".online-status");
// const ROOT_URL = "http://localhost/"; // root url
const ROOT_URL = "https://flamewatches.com/";
let onlineStatus = 1; // when goes offline status will down
let timer = 60; // intial timer
let Increment = 60; // increment of time in seconds
let watchCounter = 1; // counter and point multiplier
let pointsMultiplier = 60; // points multiplier after time is no more lift
let totalWatch = 0; // counts total watch of the video
let watchTime = 60; //set watch time of video in seconds
let videoWatch = 0; // number of video currently watching
let StartStream = 1; // start/stop video streaming
let perWatchPoints = 60; // per watch points deduction (watch * perWatchPoints)
let DeductAutoPlayPoints = 80; // value in percent 80 mean 80%
let isPlaying = 0; // video is playing status
let prevVideo = null; // previous video url
let modestbranding = 0; // diable youtube logo
let controlsOfVideo = 0; // controlls of the video on/off
let relatedVideos = 0; // on/off displaying related videos
let loopVideo = 1; // loop video
