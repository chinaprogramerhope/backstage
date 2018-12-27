import request from '@/utils/request'

/**
 * 注册
 * @param {*} userName
 * @param {*} pass
 * @param {*} passRepeat
 * @param {*} verifyCode
 */
export function register(userName, pass, passRepeat, verifyCode) {
  const data = {
    cmd: 7,
    param: {
      userName: userName,
      pass: pass,
      passRepeat: passRepeat,
      verifyCode: verifyCode
    }
  }

  var ret = request({
    url: 'http://192.168.1.127:8102',
    method: 'post',
    data
  })

  // test todo 这里为什么是空对象, 而gameGroup.vue中调用方法获取的不是空
  console.log('ret1 = ' + JSON.stringify(ret))
  return ret
}

/**
 * 获取验证码
 */
export function getVerifyCode() {
  const data = {
    cmd: 8,
    param: {
    }
  }

  var ret = request({
    url: 'http://192.168.1.127:8102',
    method: 'post',
    data
  })

  // test todo 这里为什么是空对象, 而gameGroup.vue中调用方法获取的不是空
  console.log('ret1 = ' + JSON.stringify(ret))
  return ret
}
