import request from '@/utils/request'

export function loginByUsername(username, password) {
  const data = {
    svc: 'svcAdmin',
    func: 'login',
    param: {
      adminName: username,
      password: password
    }
  }

  return request({
    // url: '/login/login',
    url: 'http://localhost:8888', // todo url定义为默认, 这里可以不用写吗
    method: 'post',
    data
  })
}

export function logout() {
  return request({
    url: '/login/logout',
    method: 'post'
  })
}

export function getUserInfo(token) {
  return request({
    url: '/user/info',
    method: 'get',
    params: { token }
  })
}

