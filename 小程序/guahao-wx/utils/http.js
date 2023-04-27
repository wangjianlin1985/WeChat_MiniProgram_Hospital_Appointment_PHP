import { config } from 'config.js'

class HTTP {

  constructor() {
    this.get_header = {
      'content-type': 'application/json'
    }
    this.post_header = {
      'content-type': 'application/x-www-form-urlencoded'
    }
  }

  /**
   * 设置统一的异常处理
   */
  setErrorHandler(handler) {
    this._errorHandler = handler;
  }

  /**
   * get请求
   */
  getRequest(url, data) {
    //data.appid = config.appid;//额外发送appid参数
    return this.requestAll(url, data, this.get_header, 'GET', true);
  }

  /**
   * post请求
   */
  postRequest(url, data) {
    //data.appid = config.appid;//额外发送appid参数
    return this.requestAll(url, data, this.post_header, 'POST', true);
  }

  /**
   * 静默get请求
   */
  get(url, data) {
    //data.appid = config.appid;//额外发送appid参数
    return this.requestAll(url, data, this.post_header, 'GET', false);
  }

  /**
   * 静默post请求
   */
  post(url, data) {
    //data.appid = config.appid;//额外发送appid参数
    return this.requestAll(url, data, this.post_header, 'POST', false);
  }

  isLogin() {
    var logined = false;
    var phone = wx.getStorageSync('phone');
    //console.log("phone:"+phone);
    if (phone != null && phone != "") {
      logined = true;
    }
    return logined;
  }

  /**
   * 发送请求
   */
  requestAll(url, data, header, method, loading) {
    return new Promise((resolve, reject) => {
      if (loading) {
        wx.showLoading()
      }
      wx.request({
        url: config.url + "/" + url,
        data: data,
        header: header,
        method: method,
        success: (res => {
          //console.log("success");
          //console.log(res);
          //200: 服务端业务处理正常结束
          if (res.statusCode === 200) {
            if (res.data.code == 1) {
              if (loading) {
                wx.hideLoading()
              }
              resolve(res)
            }
            else {
              wx.showToast({
                title: res.data.msg,
                icon: "none"
              })
              reject(res)
            }
          } else {
            //其它错误，提示用户错误信息
            if (this._errorHandler != null) {
              //如果有统一的异常处理，就先调用统一异常处理函数对异常进行处理
              this._errorHandler(res)
            }
            reject(res)
          }
        }),
        fail: (res => {
          if (loading) {
            wx.hideLoading()
          }
          wx.showToast({
            title: res.errMsg,
            icon: "none"
          })
          if (this._errorHandler != null) {
            this._errorHandler(res)
          }
          reject(res)
        }),
        complete: (res => {

        })
      })
    })
  }

  request(url, data) {
    //data.appid = config.appid;//额外发送appid参数
    return new Promise((resolve, reject) => {
      wx.showLoading()
      wx.request({
        url: config.url + "/" + url,
        data: data,
        header: { 'content-type': 'application/x-www-form-urlencoded' },
        method: 'POST',
        success: (res => {
          if (res.statusCode === 200) {
            resolve(res)
          } else {
            //其它错误，提示用户错误信息
            if (this._errorHandler != null) {
              //如果有统一的异常处理，就先调用统一异常处理函数对异常进行处理
              this._errorHandler(res)
            }
            reject(res)
          }
        }),
        fail: (res => {
          if (this._errorHandler != null) {
            this._errorHandler(res)
          }
          reject(res)
        }),
        complete: (res => {
          wx.hideLoading()
        })
      })
    })
  }

}
export { HTTP }