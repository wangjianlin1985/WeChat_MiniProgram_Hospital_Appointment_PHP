import {config} from '../../utils/config.js'
import {HTTP} from '../..//utils/http.js'
let http = new HTTP()

Page({

  /**
   * 页面的初始数据
   */
  data: {
    questionnaire:{
      //title:'关于孩子心理健康的重要性调查？'
    },
    questions:[
      // {id:1,question:'年轻人到底要不要生二胎三胎?',optiona:'坚决不生',optionb:'必须要生',optionc:'再等等看',optiond:'随缘'},
    ],
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var id = options.id;
    //console.log(id);
    this.qeustionnaire(id);
  },

  /**
   * 加载问卷明细
   */
  qeustionnaire(id){
    var _this = this;
    http.getRequest('api/questionnaire/'+id,{}).then(res => {
      _this.setData({
        questionnaire:res.data.data,
        questions:res.data.data.questions
      });
    });
  },

  /**
   * 单选按钮选中
   */
  radioChange(e){
    //console.log('radio发生change事件，携带value值为：', e.detail.value)
    var indexvalue = e.detail.value;
    var index = indexvalue.split(",")[0];
    var option = indexvalue.split(",")[1];
    this.data.questions[index].checked=true;
    this.data.questions[index].option=option;
    //console.log(this.data.questions);
  },

  /**
   * 提交保存
   */
  saveTap(){
    var _this = this;
    var questions = _this.data.questions;
    var _questions = [];
    questions.forEach(item => {
      if(item.checked){
        _questions.push(item.id+","+item.option);
      }
    });
    if(questions.length!=_questions.length){
      wx.showToast({
        title: '请完整答题!',
        icon:"error"
      })
      return;
    }
    http.getRequest('api/questionnaire/'+_this.data.questionnaire.id+'/save',{
      questions:_questions.join(';')
    }).then(res => {
      wx.showToast({
        title: '提交成功',
        duration: 1000
      })
      setTimeout(() => {
        wx.navigateBack();
      }, 1000);
    });
  },

  
})