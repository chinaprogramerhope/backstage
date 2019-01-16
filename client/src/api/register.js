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
    method: 'post',
    data
  })

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
    method: 'post',
    data
  })

  return ret
}
