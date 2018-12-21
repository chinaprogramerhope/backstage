<template>
  <div>
    <el-row>

      <el-col :span="4">
        <el-menu>
          <el-menu-item index="1">
            注册送
          </el-menu-item>
          <el-menu-item index="2">
            试玩送
          </el-menu-item>
          <el-menu-item index="3">
            首充送
          </el-menu-item>
        </el-menu>
      </el-col>

      <el-col :span="20">
        <el-form>

          <el-form-item
            :rules="[
              {required: true, message: '金额不能为空'},
              {type: 'number', message: '金额必须为数字'}
            ]"
            label="金额"
            style="width:500px"
            prop="amount"
          >
            <el-input v-model="form1.amount" type="amount" placeholder="请输入数字"/>
          </el-form-item>

          <el-form-item label="活动时间">
            <el-radio v-model="form1.radio" label="1">永久</el-radio>
            <el-radio v-model="form1.radio" label="2">时间范围</el-radio>
          </el-form-item>

          <el-form-item label="状态">
            <el-select v-model="form1.selectStatus" placeholder="">
              <el-option
                v-for="item in form1.optionsStatus"
                :key="item.value"
                :label="item.label"
                :value="item.value"/>
            </el-select>
          </el-form-item>

          <el-form-item>
            <el-button type="primary">保存</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form1: {
        amount: '',
        radio: '1',
        selectStatus: '启用',
        optionsStatus: [{
          label: '启用',
          value: 'open'
        }, {
          label: '禁用',
          value: 'close'
        }]
      }
    }
  }
}
</script>

